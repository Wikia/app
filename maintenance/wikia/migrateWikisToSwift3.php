<?php

/**
 * Script that copies files from file system to distributed storage
 *
 * @see http://www.mediawiki.org/wiki/Manual:Image_administration#Data_storage
 *
 * @author Moli
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

	const SCRIPT_PATH = '/var/log/migration_queue';
	const CMD = '/bin/bash -c "SERVER_ID=%d php migrateImagesToSwift_bulk.php %s --conf %s" >> %s 2>&1';
	
	private $disabled_wikis = [ 717284, 298117 ];
	private $db;
	
	/* time counter */
	private $time = 0;

	private $dc = null;

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
		$this->addOption( 'debug', 'Enable debug mode' );
		$this->addOption( 'force', 'Re-run script for migrated Wikis' );
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
		$wikis = $this->getOption( 'wiki', '' );

		$this->dc = $this->getOption('dc',$wgWikiaDatacenter);

		# don't migrate top 200 Wikis
		$top200Wikis = array();
		if ( $this->hasOption('all') ) {
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

		$this->db = $this->getDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$order = $this->hasOption('reverse') ? " DESC" : "";
		$res = $this->db->select(
			array( 'city_list', 'city_variables' ),
			array( 'city_id', 'city_dbname' ),
			array(
				'cv_value is null or cv_value != "b:1;"', // wgEnableSwiftBackend == true
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

		$this->output("Building list of wiki IDs...\n");
		$queue = array();
		while ( $row = $res->fetchObject() ) {
			$id = intval($row->city_id);
			$dbname = $row->city_dbname;
			if ( !in_array( $id, $this->disabled_wikis ) ) {
				$queue[$id] = $dbname;
			}
		}
		$this->output(sprintf("Scheduling %d wikis for migration...\n",count($queue)));

		$this->output( "\nRun migrateImagesToSwift script \n" );

		$this->output( "Building list of processes to run...\n");
		$processes = array();
		foreach ( $queue as $id => $dbname ) {
			$processes[] = $this->getProcess($id,$dbname);
		}

		$threads = $this->getOption('threads',self::THREADS_DEFAULT);
		$this->output( "Using {$threads} threads...\n");
		$runner = new \Wikia\Swift\Process\Runner($processes,$threads);
		$runner->run();

		$this->output( sprintf( "\nMigrated %d Wikis in %s\n", $migrated, Wikia::timeDuration( time() - $this->time ) ) );
		$this->output( "\nDone!\n" );
	}

	protected function getProcess( $cityId, $dbname ) {
		$opts = "--dry-run --local --dc={$this->dc} --debug" ;
		$logFile = $this->getLogPath($dbname);
		$cmd = sprintf( self::CMD, $cityId, $opts, $this->getOption('conf'), $logFile );
		return new \Wikia\Swift\Process\Process($cmd);
	}
}

$maintClass = "MigrateWikisToSwift3";
require_once( RUN_MAINTENANCE_IF_MAIN );
