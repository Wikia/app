<?php

/**
 * Script that marks a given wiki to be removed by /extensions/wikia/WikiFactory/Close/maintenance.php script
 *
 * @author macbre
 * @see SUS-3255
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class CloseWiki extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Marks a given wiki for removal';
		$this->addOption( 'wiki-id', 'wiki ID to close', false, true );
		$this->addOption( 'list-file', 'path to file with wiki IDs to close', false, true );
		$this->addOption( 'reason', 'reason for close', true, true );
	}

	/**
	 * Mark given wiki as queued for removal
	 *
	 * @param integer $wikiId city ID
	 * @param string  $reason why we marked the wiki
	 * @return bool
	 */
	private function markWikiAsClosed( int $wikiId, string $reason ) :bool {
		try {
			$res = WikiFactory::setPublicStatus( WikiFactory::CLOSE_ACTION, $wikiId, $reason );
			
			if ( $res === WikiFactory::CLOSE_ACTION ) {
				WikiFactory::setFlags( $wikiId, WikiFactory::FLAG_FREE_WIKI_URL | WikiFactory::FLAG_CREATE_DB_DUMP | WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE );
				WikiFactory::clearCache( $wikiId );
			}

			return $res !== false;
		} catch ( DBError $error ) {
			MWExceptionHandler::printError( $error->getText() );
			return false;
		}
	}

	private function closeMultipleWikis( string $listFile, string $reason ) {
		$file = fopen( $listFile, 'r' );

		while ( ( $line = fgets( $file ) ) !== false ) {
			$wikiId = intval( $line );
			$ok = $this->markWikiAsClosed( intval( $line ), $reason );

			if ( $ok ) {
				$this->output( "Wiki ID $wikiId has been marked for removal!\n" );
			} else {
				$this->error( "Failed to mark wiki ID $wikiId for removal!" );
			}
		}
	}

	public function execute() {
		$reason = $this->getOption( 'reason' );

		$wikiId = $this->getOption( 'wiki-id' );
		$listFile = $this->getOption( 'list-file' );

		if ( $wikiId ) {
			$ok = $this->markWikiAsClosed( $wikiId, $reason );

			if ( $ok ) {
				$this->output( "Wiki has been marked for removal!\n" );
			} else {
				$this->error( 'Failed to mark a wiki for removal!', 1 );
			}
		} elseif ( $listFile ) {
			$this->closeMultipleWikis( $listFile, $reason );
		} else {
			die( 'One of --wiki-id or --list-file arguments must be provided' );
		}
	}
}

$maintClass = CloseWiki::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
