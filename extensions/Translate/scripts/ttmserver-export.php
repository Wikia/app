<?php
/**
 * Script to bootstrap TTMServer translation memory
 *
 * @author Niklas Laxström
 *
 * @copyright Copyright © 2010-2012, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

// Standard boilerplate to define $IP
if ( getenv( 'MW_INSTALL_PATH' ) !== false ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$dir = dirname( __FILE__ ); $IP = "$dir/../../..";
}
require_once( "$IP/maintenance/Maintenance.php" );

/**
 * Script to bootstrap translatetoolkit translation memory.
 * @since 2012-01-26
 */
class TTMServerBootstrap extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Script to bootstrap TTMServer';
		$this->addOption( 'threads', 'Number of threads', /*required*/false, /*has arg*/true );
		$this->setBatchSize( 100 );
		$this->start = microtime( true );
	}

	protected function statusLine( $text, $channel = null ) {
		$pid =  sprintf( "%5s", getmypid() );
		$prefix = sprintf( "%6.2f", microtime( true ) - $this->start );
		$mem = sprintf( "%5.1fM", ( memory_get_usage( true ) / ( 1024 * 1024 ) ) );
		$this->output( "$pid $prefix $mem  $text", $channel );
	}

	public function execute() {
		$server = TTMServer::primary();
		if ( $server instanceof FakeTTMServer ) {
			$this->error( "Translation memory is not configured properly", 1 );
		}

		$dbw = $server->getDB( DB_MASTER );

		$this->statusLine( 'Deleting sources.. ', 1 );
		$dbw->delete( 'translate_tms', '*', __METHOD__ );
		$this->output( 'translations.. ', 1 );
		$dbw->delete( 'translate_tmt', '*', __METHOD__ );
		$this->output( 'fulltext.. ', 1 );
		$dbw->delete( 'translate_tmf', '*', __METHOD__ );
		$table = $dbw->tableName( 'translate_tmf' );
		$dbw->query( "DROP INDEX tmf_text ON $table" );
		$this->output( 'done!', 1 );

		$this->statusLine( 'Loading groups... ', 2 );
		$groups = MessageGroups::singleton()->getGroups();
		$this->output( 'done!', 2 );


		$threads = $this->getOption( 'threads', 1 );
		$pids = array();

		foreach ( $groups as $id => $group ) {
			if ( $group->isMeta() ) {
				continue;
			}

			// Fork to avoid unbounded memory usage growth
			$pid = pcntl_fork();

			if ( $pid === 0 ) {
				// Child, reseed because there is no bug in PHP:
				// http://bugs.php.net/bug.php?id=42465
				mt_srand( getmypid() );
				$this->exportGroup( $group, $threads > 1 );
				exit();
			} elseif ( $pid === -1 ) {
				// Fork failed do it serialized
				$this->exportGroup( $group );
			} else {
				$this->statusLine( "Forked thread $pid to handle $id\n" );
				$pids[$pid] = true;

				// If we hit the thread limit, wait for any child to finish.
				if ( count( $pids ) >= $threads ) {
					$status = 0;
					$pid = pcntl_wait( $status );
					unset( $pids[$pid] );
				}
			}
		}

		// Return control after all threads have finished.
		foreach ( array_keys( $pids ) as $pid ) {
			$status = 0;
			pcntl_waitpid( $pid, $status );
		}

		$this->statusLine( 'Adding fulltext index...', 9 );
		$table = $dbw->tableName( 'translate_tmf' );
		$dbw->query( "CREATE FULLTEXT INDEX tmf_text ON $table (tmf_text)" );
		$this->output( ' done!', 9 );
	}

	protected function exportGroup( MessageGroup $group, $multi = false ) {
		// Make sure all existing connections are dead,
		// we can't use them in forked children.
		LBFactory::destroyInstance();
		$server = TTMServer::primary();

		$id = $group->getId();
		$sourceLanguage = $group->getSourceLanguage();

		if ( $multi ) {
			$stats = MessageGroupStats::forGroup( $id );
			$this->statusLine( "Loaded stats for $id\n" );
		} else {
			$this->statusLine( "Loading stats... ", 4 );
			$stats = MessageGroupStats::forGroup( $id );
			$this->output( "done!", 4 );
			$this->statusLine( "Inserting sources: ", 5 );
		}

		$collection = $group->initCollection( $sourceLanguage );
		$collection->filter( 'ignored' );
		$collection->filter( 'optional' );
		$collection->initMessages();

		$sids = array();
		$counter = 0;

		foreach ( $collection->keys() as $mkey => $title ) {
			$def = $collection[$mkey]->definition();
			$sids[$mkey] = $server->insertSource( $title, $sourceLanguage, $def );
			if ( ++$counter % $this->mBatchSize === 0 && !$multi ) {
				wfWaitForSlaves( 10 );
				$this->output( '.', 5 );
			}
		}

		$total = count( $sids );
		if ( $multi ) {
			$this->statusLine( "Inserted $total source entries for $id\n" );
		} else {
			$this->output( "$total entries", 5 );
			$this->statusLine( "Inserting translations...", 6 );
		}

		$dbw = $server->getDB( DB_MASTER );

		foreach ( $stats as $targetLanguage => $numbers ) {
			if ( $targetLanguage === $sourceLanguage ) {
				continue;
			}
			if ( $numbers[MessageGroupStats::TRANSLATED] === 0 ) {
				continue;
			}

			if ( !$multi ) {
				$this->output( sprintf( "%19s  ", $targetLanguage ), $targetLanguage );
			}

			$collection->resetForNewLanguage( $targetLanguage );
			$collection->filter( 'ignored' );
			$collection->filter( 'optional' );
			$collection->filter( 'translated', false );
			$collection->loadTranslations();

			$inserts = array();
			foreach ( $collection->keys() as $mkey => $title ) {
				$inserts[] = array(
					'tmt_sid' => $sids[$mkey],
					'tmt_lang' => $targetLanguage,
					'tmt_text' => $collection[$mkey]->translation()
				);
			}

			do {
				$batch = array_splice( $inserts, 0, $this->mBatchSize );
				$dbw->insert( 'translate_tmt', $batch, __METHOD__ );

				if ( !$multi ) {
					$this->output( '.', $targetLanguage );
				}
				wfWaitForSlaves( 10 );
			} while ( count( $inserts ) );
		}

		if ( $multi ) {
			$this->statusLine( "Inserted translations for $id\n" );
		}
	}

}

$maintClass = 'TTMServerBootstrap';
require_once( RUN_MAINTENANCE_IF_MAIN );
