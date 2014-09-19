<?php

/**
 * Calculate md5 checksums for images on wikis
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
class CalculateImagesMd5Runner extends Maintenance {

	const THREADS_DEFAULT = 3;

	const CMD = '/bin/bash -c "SERVER_ID=%d php -ddisplay_errors=1 calculateImagesMd5.php %s --conf %s" > /dev/null 2>&1';
	
	private $db;
	
	/* time counter */
	private $time = 0;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'wiki', 'Run script for Wikis (comma separated list of Wikis)' );
		$this->addOption( 'limit', 'Number of Wikis to migrate (default: no limit)' );
		$this->addOption( 'reverse', 'Reversed order' );
		$this->addOption( 'threads', 'Number of threads (default: 40)' );
		$this->addOption( 'debug', 'Enable debug mode' );
		$this->mDescription = 'Calculate md5 checksums for images on multiple wikis';
	}
	
	public function execute() {
		global $wgExternalSharedDB;

		$this->output( "md5 calculation started ... \n" );
		$this->time = time();
		$migrated = 0;

		$limit = $this->getOption( 'limit', -1 );
		$debug = $this->hasOption( 'debug' );
		$wikis = $this->getOption( 'wiki', '' );

		$this->db = $this->getDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$where = array();
		if ( !empty($wikis) ) {
			$where['city_id'] = explode(',',$wikis);
		}
		$order = $this->hasOption('reverse') ? " DESC" : "";
		$res = $this->db->select(
			array( 'city_list' ),
			array( 'city_id', 'city_dbname' ),
			$where,
			__CLASS__,
			array_merge(array(
					'ORDER BY' => "city_last_timestamp{$order}, city_id{$order}",
				),( $limit > 0 ? array(
					'LIMIT' => $limit,
				) : array() )
			)
		);

		$this->output("Building list of wiki IDs...\n");
		$queue = array();
		while ( $row = $res->fetchObject() ) {
			$id = intval($row->city_id);
			$dbname = $row->city_dbname;
			$queue[$id] = $dbname;
		}
		$this->output(sprintf("Scheduling %d wikis for migration...\n",count($queue)));

		$this->output( "\nRun migrateImagesToSwift script \n" );

		$this->output( "Building list of processes to run...\n");
		$processes = array();
		foreach ( $queue as $id => $dbname ) {
			$processes[] = $this->getProcess($id);
		}

		$threads = $this->getOption('threads',self::THREADS_DEFAULT);
		$this->output( "Using {$threads} threads...\n");
		$runner = new \Wikia\Swift\Process\Runner($processes,$threads);
		$runner->run();

		$this->output( sprintf( "\nMigrated %d Wikis in %s\n", $migrated, Wikia::timeDuration( time() - $this->time ) ) );
		$this->output( "\nDone!\n" );
	}

	protected function getProcess( $cityId ) {
		$opts = "--local --debug" ;
		$cmd = sprintf( self::CMD, $cityId, $opts, $this->getOption('conf') );
		return new \Wikia\Swift\Process\Process($cmd);
	}
}

$maintClass = "CalculateImagesMd5Runner";
require_once( RUN_MAINTENANCE_IF_MAIN );
