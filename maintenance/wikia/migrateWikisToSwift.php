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
	migration_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;
*/

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class MigrateWikisToSwift extends Maintenance {
	CONST DEFAULT_LIMIT = 1000;
	CONST CMD = 'http_proxy="" run_maintenance --db %s --script "wikia/migrateImagesToSwift.php"';
	
	private $disabled_wikis = [ 717284, 298117 ];
	private $db;
	
	/* time counter */
	private $time = 0;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'wikia', 'Run script for Wikia ID' );
		$this->addOption( 'limit', 'Number of Wikis to migrate' );
		$this->addOption( 'debug', 'Enable debug mode' );
		$this->mDescription = 'Migrate images for all Wikis';
	}

	public function execute() {
		global $wgExternalSharedDB;

		$this->output( "Wikis migration started ... \n" );
		$this->time = time();
		$migrated = 0;

		$limit = $this->getOption( 'limit', self::DEFAULT_LIMIT );
		$debug = $this->hasOption( 'debug' );

		# don't migrate top 200 Wikis
		$top200Wikis = DataMartService::getWAM200Wikis();
		
		# don't migrate video.wikia.com & corp.wikia.com
		$this->disabled_wikis = array_merge( $top200Wikis, $this->disabled_wikis );

		if ( $debug ) {
			$this->output( "Top 200 Wikis: " . implode( ", ", $top200Wikis ) . "\n" );
		}

		$this->db = $this->getDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$res = $this->db->select( 
			[ 'city_list, city_image_migrate' ], 
			[ 'city_list.city_id', 'city_list.city_dbname' ],
			[ 'city_public' => 1, 'city_image_migrate.city_id is null' ],
			'MigrateImagesToSwift',
			[ 'ORDER BY' => 'city_id', 'LIMIT' => $limit ],
			[ 'city_image_migrate' => 
				[ 'LEFT JOIN', [ 'city_image_migrate.city_id = city_list.city_id' ] ]
			] 
		);

		while ( $row = $res->fetchRow() ) {
			$startTime = time();
			$this->output( "\tMigrate {$row->city_dbname} ... " );
			if ( in_array( $row->city_id, $this->disabled_wikis ) ) {
				$this->output( "don't migrate it now \n" );
				continue;
			}

			# run main migration script written by Macbre
			$cmd = sprintf( self::CMD, $row->city_dbname );
			if ( $debug ) {
				$this->output( "\n\tRun cmd: {$cmd} \n" );
			}
			$result = wfShellExec( $cmd, $retval );
			if ( $retval ) {
				$this->output( "Error code $retval: $result \n" );
			} else {
				$this->output( "Done in " . Wikia::timeDuration( time() - $this->time ) . "\n" );
				
				# update status in database 
				$this->db->replace( 'city_image_migrate', [ 'city_id' ], [ 'city_id' => $row->city_id ], 'MigrateImagesToSwift' );
			}
			
			$migrated++;
		}

		$this->output( sprintf( "\nMigrated %d Wikis in %s\n", $migrated, Wikia::timeDuration( time() - $this->time ) ) );
		$this->output( "\nDone!\n" );
	}
}

$maintClass = "MigrateWikisToSwift";
require_once( RUN_MAINTENANCE_IF_MAIN );
