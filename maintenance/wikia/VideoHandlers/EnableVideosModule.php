<?php
/**
 * EnableVideosModule
 *
 * Simple script to enable VideosModule on a per-wiki basis
 * Takes a file containing a line-by-line list of URLs as first parameter
 *
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);
putenv("SERVER_ID=177");

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

/**
 * Class EnableVideosModule
 */
class EnableVideosModule extends Maintenance {

	protected $verbose = false;
	protected $test    = false;
	protected $file    = '';
	protected $dbname  = '';

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Pre-populate LVS suggestions";
		$this->addOption( 'test', 'Test mode; make no changes', false, false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'file', 'File of dbnames', false, true, 'f' );
		$this->addOption( 'dbname', 'A specific dbname', false, true, 'd' );
	}

	public function execute() {
		$this->test    = $this->hasOption('test');
		$this->verbose = $this->hasOption('verbose');
		$this->file    = $this->getOption('file', '');
		$this->dbname  = $this->getOption('dbname', '');

		if ( $this->test ) {
			echo "\n=== TEST MODE ===\n";
		}

		if ( $this->file ) {
			echo "Reading from ".$this->file." ...\n";
			$dbnames = file( $this->file );
		} else if ( $this->dbname ) {
			$dbnames = [ $this->dbname ];
		} else {
			echo "ERROR: List file empty or not readable. Please provide a line-by-line list of wikis.\n";
			echo "USAGE: php EnableVideosModule.php /path/to/file\n";

			exit;
		}

		foreach ( $dbnames as $db ) {

			$this->debug( "Running on $db ...\n" );

			// get wiki ID
			$id = $this->dbname2id( $db );


			if ( empty( $id ) ) {
				echo "\t$db: ERROR (not found in WikiFactory)\n";
				continue;
			} else {
				$this->debug( "\tWiki ID ($db): $id\n" );
			}

			if ( $id == 177 ) {
				echo "\tDefaulted to community, not likely a valid wiki, skipping...\n";
				continue;
			}

			if ( !$this->test ) {
				$this->debug( "\tSetting ... wgVideosModuleABTest, wgEnableVideosModuleExt\n" );
				WikiFactory::setVarByName( 'wgVideosModuleABTest', $id, 'bottom' );
				WikiFactory::setVarByName( 'wgEnableVideosModuleExt', $id, true );

				WikiFactory::clearCache( $id );
				$this->debug( "\tdone\n" );
			}
		}
	}

	function dbname2id( $db ) {
		$dbr = wfGetDB( DB_SLAVE, null, 'wikicities' );
		$row = $dbr->selectRow(
			array( "city_list" ),
			array( "city_id" ),
			array( "city_dbname" => $db ),
			__METHOD__
		);
		$city_id = is_object( $row ) ? $row->city_id : null;
		return $city_id;
	}

	function debug( $msg ) {
		if ( !$this->verbose ) {
			return;
		}
		echo "$msg\n";
	}
}

$maintClass = "EnableVideosModule";
require_once( RUN_MAINTENANCE_IF_MAIN );

