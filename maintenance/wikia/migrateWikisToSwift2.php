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

/**
 * Maintenance script class
 */
class MigrateWikisToSwift extends Maintenance {
	CONST DEFAULT_LIMIT = 1000;
	const MIGRATE_PROCS = 50;
	const SCRIPT_PROCS = 1;
	const SCRIPT_PATH = '/var/log/runit/swift_migration';
	CONST CMD = 'run_maintenance --conf=%s --db=%s --script "wikia/migrateImagesToSwift.php%s" --procs=%d >> %s/debug.log & ';
	
	private $disabled_wikis = [ 717284, 298117 ];
	private $db;
	
	/* time counter */
	private $time = 0;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'wiki', 'Run script for Wikis (comma separated list of Wikis)' );
		$this->addOption( 'limit', 'Number of Wikis to migrate' );
		$this->addOption( 'locked', 'Max number of locked Wikis' ); 
		$this->addOption( 'debug', 'Enable debug mode' );
		$this->addOption( 'force', 'Re-reun script for migrated Wikis' );
		$this->mDescription = 'Migrate images for all Wikis';
	}
	
	private function makePath( $dbname ) {
		$path = sprintf( "%s/%s/%s/%s", self::SCRIPT_PATH, substr($dbname, 0, 1), substr($dbname, 0, 3),$dbname);
		wfMkdirParents( $path );
		return $path;
	}
	
	private function isLocked( $procs ) {		
		$is_locked = true;
		while ( $is_locked ) {
			$this->output( "Checked number of processed Wikis ... " );
		
			$db_locked = $this->db->selectField( 'city_image_migrate', 'COUNT(*)', [ 'locked' => 1 ], __METHOD__ );
			if ( $db_locked >= $procs ) {
				$this->output( "sleep 10 secods ... \n" );
				sleep( 10 );
			} else {
				$this->output( "$db_locked Wikis in db - let's continue ... \n" );
				$is_locked = false;
			}
		}
		
		return true;
	}
	
	public function execute() {
		global $wgExternalSharedDB;

		$this->output( "Wikis migration started ... \n" );
		$this->time = time();
		$migrated = 0;

		$limit = $this->getOption( 'limit', self::DEFAULT_LIMIT );
		$debug = $this->hasOption( 'debug' );
		$procs = $this->getOption( 'procs', self::MIGRATE_PROCS );
		$force = $this->hasOption( 'force' );
		$wikis = $this->getOption( 'wiki', '' );

		# don't migrate top 200 Wikis
		$top200Wikis = DataMartService::getWAM200Wikis();
		
		if ( count($top200Wikis) != 200 ) {
			$this->output( "Number of Top 200 Wikis is different than 200 !\n" );
			exit;
		}
		
		# don't migrate video.wikia.com & corp.wikia.com
		$this->disabled_wikis = array_merge( $top200Wikis, $this->disabled_wikis );

		if ( $debug ) {
			$this->output( "Top 200 Wikis: " . implode( ", ", $top200Wikis ) . "\n" );
		}

		$this->db = $this->getDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$where = [ 'city_public' => 1, 'city_image_migrate.city_id is null' ];
		if ( !empty( $wikis  ) ) {
			$where[ 'city_list.city_id' ] = explode( ",", $wikis );
		}
		$join = [ 'city_image_migrate.city_id = city_list.city_id', 'city_image_migrate.locked is not null' ];

		$res = $this->db->select(
			[ 'city_list', 'city_image_migrate' ], 
			[ 'city_list.city_id', 'city_list.city_dbname' ],
			$where,
			'MigrateImagesToSwift',
			[ 'ORDER BY' => 'city_id', 'LIMIT' => $limit ],
			[ 'city_image_migrate' => 
				[ 'LEFT JOIN', $join ]
			]
		);

		$to_migrate = [];
		$i = 0; $x = 0;
		while ( $row = $res->fetchObject() ) {
			$this->output( "\tAdd {$row->city_dbname} to migration package ... " );
			if ( in_array( $row->city_id, $this->disabled_wikis ) ) {
				$this->output( "don't migrate it now \n" );
				continue;
			}
			
			$to_migrate[ $row->city_id ] = $row->city_dbname;
			
			$this->output( "done \n " );
			$i++;
		}

		$this->output( "\n\nRun migrateImagesToSwift script \n" );

		foreach ( $to_migrate as $id => $dbname ) {
			# check how many Wikis is locked and sleep if needed 
			$this->isLocked( $procs );
			
			# run main migration script written by Macbre
			$this->output( "\tMigrate Wiki {$id}: {$dbname} ... " );
			$cmd = sprintf( self::CMD, $this->getOption( 'conf' ), $dbname, ( $force ) ? ' --force' : '', self::SCRIPT_PROCS, $this->makePath( $dbname ) );
			if ( $debug ) {
				$this->output( "\n\tRun cmd: {$cmd} \n" );
			}
			global $wgMaxShellTime;
			$wgMaxShellTime = 0;
			$result = wfShellExec( $cmd, $retval );
			if ( $retval ) {
				$this->output( "Error code $retval: $result \n" );
			} else {
				$this->output( "Done in " . Wikia::timeDuration( time() - $this->time ) . "\n" );				
			}
			
			// wait a bit to prevent deadlocks (from 0 to 2 sec)
			usleep( mt_rand(0,2000) * 1000 );
		
			$migrated++;
		}

		$this->output( sprintf( "\nMigrated %d Wikis in %s\n", $migrated, Wikia::timeDuration( time() - $this->time ) ) );
		$this->output( "\nDone!\n" );
	}
}

$maintClass = "MigrateWikisToSwift";
require_once( RUN_MAINTENANCE_IF_MAIN );
