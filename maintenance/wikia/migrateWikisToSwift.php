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
	const MIGRATE_PACKAGE = 50;
	const SCRIPT_PROCS = 50;
	CONST CMD = 'run_maintenance --conf=%s --where="city_id in (%s)" --script "wikia/migrateImagesToSwift.php%s" --procs=%d ';
	
	private $disabled_wikis = [
		717284, // corp.wikia.com
		298117  // video.wikia.com
	];
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
		$this->addOption( 'debug', 'Enable debug mode' );
		$this->addOption( 'force', 'Re-reun script for migrated Wikis' );
		$this->mDescription = 'Migrate images for all Wikis';
	}

	public function execute() {
		global $wgExternalSharedDB;

		$this->output( "Wikis migration started ... \n" );
		$this->time = time();
		$migrated = 0;

		$limit = $this->getOption( 'limit', self::DEFAULT_LIMIT );
		$debug = $this->hasOption( 'debug' );
		$force = $this->hasOption( 'force' );
		$wikis = $this->getOption( 'wiki', '' );

		# don't migrate top 200 Wikis
		$top200Wikis = DataMartService::getWAM200Wikis();
		
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
			$startTime = time();
			$this->output( "\tAdd {$row->city_dbname} to migration package ... " );
			if ( in_array( $row->city_id, $this->disabled_wikis ) ) {
				$this->output( "don't migrate it now \n" );
				continue;
			} 
			
			if ( $i == self::MIGRATE_PACKAGE ) $x++;
			$to_migrate[ $x ][] = $row->city_id;
			
			$this->output( "done \n " );
			$i++;
		}

		$this->output( "\n\nRun migrateImagesToSwift script \n" );

		foreach ( $to_migrate as $id => $list_wikis ) {
			# run main migration script written by Macbre
			$wikis = implode(",", $list_wikis );
			$this->output( "\tMigrate package {$id}: {$wikis} ... " );
			$cmd = sprintf( self::CMD, $this->getOption( 'conf' ), $wikis, ( $force ) ? ' --force' : '', self::SCRIPT_PROCS );
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
			
			$migrated++;
			$migrated_wikis = count( $list_wikis);
		}

		$this->output( sprintf( "\nMigrated %d Wikis (%d packages) in %s\n", $migrated_wikis, $migrated, Wikia::timeDuration( time() - $this->time ) ) );
		$this->output( "\nDone!\n" );
	}
}

$maintClass = "MigrateWikisToSwift";
require_once( RUN_MAINTENANCE_IF_MAIN );
