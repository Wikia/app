<?php

/**
 * Script that copies files from file system to distributed storage
 *
 * @see http://www.mediawiki.org/wiki/Manual:Image_administration#Data_storage
 *
 * @author Moli
 * @author wladek
 * @ingroup Maintenance
 */

/* Table 
CREATE table city_image_migrate (
	city_id int UNSIGNED NOT NULL PRIMARY KEY,
	lock tinyint(1) UNSIGNED DEFAULT NULL,
	migration_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;
*/

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );
require_once( __DIR__ . '/../../includes/wikia/swift/all.php' );

/**
 * Maintenance script class
 */
class MigrateWikisToSwift3 extends Maintenance {

	const THREADS_DEFAULT = 40;
	const DELAY_DEFAULT = 0;

	const SCRIPT_PATH = '/var/log/migration_queue';

	private $disabled_wikis = [ 717284, 298117 ];
	private $db;
	
	/* time counter */
	private $time = 0;

	private $dc = null;
	private $dryRun = null;
	private $noDeletes = null;
	private $calculateMd5 = null;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'wiki', 'Run script for Wikis (comma separated list of Wikis)' );
		$this->addOption( 'limit', 'Number of Wikis to migrate (default: no limit)' );
		$this->addOption( 'all', 'Do not skip top 200 wikis.' );
		$this->addOption( 'reverse', 'Reversed order' );
		$this->addOption( 'threads', 'Number of threads (default: 40)' );
		$this->addOption( 'delay', 'Number of seconds to wait before spawning next process (default: 0)' );
		$this->addOption( 'debug', 'Enable debug mode' );
		$this->addOption( 'force', 'Perform the migration even if $wgEnableSwiftFileBackend = true' );
		$this->addOption( 'dry-run', 'Perform file uploads but don\'t switch wiki to Swift' );
		$this->addOption( 'no-deletes', 'Do not remove orphans in ceph' );
		$this->addOption( 'md5', 'Calculate md5 of files only' );
		$this->addOption( 'stats-only', 'Print statistics only' );
		$this->addOption( 'dc', 'Target datacenter(s), comma-separated list (default: local datacenter)' );
		$this->mDescription = 'Migrate images for all Wikis';
	}
	
	private function getLogPath( $dbname ) {
		$path = sprintf( "%s/%s/%s", self::SCRIPT_PATH, substr($dbname, 0, 1), substr($dbname, 0, 3));
		wfMkdirParents( $path );
		return sprintf("%s/%s.log",$path,$dbname);
	}
	
	public function execute() {
		global $wgExternalSharedDB, $wgWikiaDatacenter;

		$this->output( "Wikis migration started ... \n" );
		$this->time = time();
		$migrated = 0;

		$limit = $this->getOption( 'limit', -1 );
		$debug = $this->hasOption( 'debug' );
		$force = $this->hasOption( 'force' );
		$wikis = $this->getOption( 'wiki', null );
		$this->dryRun = $this->hasOption('dry-run');
		$this->noDeletes = $this->hasOption('no-deletes');
		$this->calculateMd5 = $this->hasOption('md5');

		$this->dc = $this->getOption('dc','sjc,res');

		# don't migrate top 200 Wikis
		$top200Wikis = array();
		if ( !$this->hasOption('all') ) {
			$top200Wikis = DataMartService::getWAM200Wikis();

			if ( count($top200Wikis) != 200 ) {
				$this->output( "Number of Top 200 Wikis is different than 200 !\n" );
				exit;
			}

			if ( $debug ) {
				$this->output( "Top 200 Wikis: " . implode( ", ", $top200Wikis ) . "\n" );
			}
		}

		# don't migrate video.wikia.com & corp.wikia.com
		$this->disabled_wikis = array_merge( $top200Wikis, $this->disabled_wikis );
		foreach ($this->disabled_wikis as $k => $v) {
			$this->disabled_wikis[$k] = intval($v);
		}

		$wikiIds = null;
		if ( $wikis !== null ) {
			$wikiIds = array();
			foreach (explode(',',$wikis) as $id) {
				if ( is_numeric($id) && $id >= 0 ) {
					$wikiIds[] = $id;
				}
			}
			if ( count($wikiIds) == 0 ) {
				$wikiIds = null;
			}
		}

		$this->db = $this->getDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$order = $this->hasOption('reverse') ? " DESC" : "";
		$res = $this->db->select(
			array( 'city_list', 'city_variables' ),
			array( 'city_id', 'city_dbname' ),
			array_merge(
			array(
				'city_public' => 1,
			),
			( !$force ? array(
				'cv_value is null or cv_value != "b:1;"', // not "wgEnableSwiftBackend == true"
				) : array() ),
			( is_array($wikiIds) ? array(
				'city_id' => $wikiIds,
				) : array() )
			),
			__CLASS__,
			array_merge(array(
				'ORDER BY' => "city_last_timestamp{$order}, city_id{$order}",
			),( $limit > 0 ? array(
				'LIMIT' => $limit,
				) : array() )
			),
			array(
				'city_variables' => array(
					'LEFT JOIN',
					'city_list.city_id = city_variables.cv_city_id and cv_variable_id = 1334',
				)
			)
		);
		$this->output(sprintf("Found %d wikis in database...\n",$res->numRows()));

		$this->output("Building list of wiki IDs...\n");
		$removedCount = 0;
		$queue = array();
		while ( $row = $res->fetchObject() ) {
			$id = intval($row->city_id);
			$dbname = $row->city_dbname;
			if ( !in_array( $id, $this->disabled_wikis ) ) {
				$queue[$id] = $dbname;
			} else {
				$removedCount++;
			}
		}
		$this->output(sprintf("Skipped %d wikis that are on blacklist...\n",$removedCount));
		$this->output(sprintf("Scheduling %d wikis for migration...\n",count($queue)));

		if ( $this->hasOption('stats-only') ) {
			return;
		}

		$this->output( "\nRun migrateImagesToSwift script \n" );

		$this->output( "Building list of processes to run...\n");
		$processes = array();
		foreach ( $queue as $id => $dbname ) {
			if ( $this->calculateMd5 ) {
				$process = $this->getMd5Process($id,$dbname);
			} else {
				$process = $this->getMigrationProcess($id,$dbname);
			}
			$processes[] = $process;
		}

		$threads = $this->getOption('threads',self::THREADS_DEFAULT);
		$threads = intval($threads);
		$threadDelay = $this->getOption('delay',self::DELAY_DEFAULT);
		$threadDelay = intval($threadDelay);
		$this->output( "Using {$threads} threads...\n");
		$runner = new \Wikia\Swift\Process\Runner($processes,$threads,$threadDelay);
		$runner->run();

		$this->output( sprintf( "\nMigrated %d Wikis in %s\n", $migrated, Wikia::timeDuration( time() - $this->time ) ) );
		$this->output( "\nDone!\n" );
	}

	const CMD_MD5 = '/bin/bash -c "SERVER_ID=%d php -ddisplay_errors=1 calculateImagesMd5.php %s --conf %s" >> %s 2>&1';
	protected function getMd5Process( $cityId, $dbname ) {
		$opts = "--local --debug" ;
//		$logFile = $this->getLogPath($dbname);
		$logFile = '/dev/null';
		$cmd = sprintf( self::CMD_MD5, $cityId, $opts, $this->getOption('conf'), $logFile );
		return new \Wikia\Swift\Process\Process($cmd);
	}

	const CMD_MIGRATION = '/bin/bash -c "SERVER_ID=%d php -ddisplay_errors=1 migrateImagesToSwift_bulk.php %s --conf %s" >> %s 2>&1';
	protected function getMigrationProcess( $cityId, $dbname ) {
		$opts = "--local --diff --debug --threads=10" ;
		$opts .= " --dc={$this->dc}";
		if ( $this->dryRun ) {
			$opts .= " --dry-run";
		} else {
			$opts .= " --wait --force";
		}
		if ( $this->noDeletes ) {
			$opts .= " --no-deletes";
		}
		$logFile = $this->getLogPath($dbname);
		$cmd = sprintf( self::CMD_MIGRATION, $cityId, $opts, $this->getOption('conf'), $logFile );
		return new \Wikia\Swift\Process\Process($cmd);
	}
}

$maintClass = "MigrateWikisToSwift3";
require_once( RUN_MAINTENANCE_IF_MAIN );
