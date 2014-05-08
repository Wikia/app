<?php
/**
 * EnableVideosModule
 *
 * Simple script to disable the Related Videos Module across all wikis except for Hubs as it's still relying on
 * some of the Related Videos Module extension functionality.
 *
 * Takes a file containing a line-by-line list of wikis to disable (not including the Hubs wiki, wikiaglobal). Note, the
 * list of wikis to disable was constructed using the following query on the production wikicites database:
 *
 * SELECT city_dbname FROM `city_variables`,`city_list`
 * WHERE (city_id = cv_city_id) AND (cv_value = 'b:1;')
 * AND (cv_variable_id = '1123')
 * AND city_dbname != 'wikiaglobal';
 *
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);
putenv("SERVER_ID=177");

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

/**
 * Class disableRelatedVideosExt
 */
class disableRelatedVideosExt extends Maintenance {

	const RELATED_VIDEOS_VAR = 'wgEnableRelatedVideosExt';

	protected $verbose  = false;
	protected $test     = false;
	protected $file     = '';


	public function __construct() {
		parent::__construct();
		$this->mDescription = "Disable the Related Videos Module where enabled (except on hubs)";
		$this->addOption( 'test', 'Test mode; make no changes', false, false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'file', 'File of wiki database names', false, true, 'f' );
	}

	public function execute() {
		$this->test     = $this->hasOption('test');
		$this->verbose  = $this->hasOption('verbose');
		$this->file     = $this->getOption('file', '');

		if ( $this->test ) {
			echo "\n=== TEST MODE ===\n";
		}

		if ( $this->file ) {
			echo "Reading from " . $this->file . " ...\n";
			$dbnames = file( $this->file );
		} else {
			echo "ERROR: List file empty or not readable. Please provide a line-by-line list of wikis.\n";
			echo "USAGE: php disableRelatedVideosExt.php --file /path/to/file\n";

			exit;
		}

		foreach ( $dbnames as $db ) {
			$db = trim($db);
			echo "Running on $db ...\n";

			// get wiki ID
			$id = WikiFactory::DBtoID( $db );


			if ( empty( $id ) ) {
				echo "\t$db: ERROR (not found in WikiFactory)\n";
				continue;
			} else {
				$this->debug( "\tWiki ID ($db): $id" );
			}

			if ( !$this->test ) {
				$this->debug( "\tDisabling Related Videos Module on $db..." );
				WikiFactory::setVarByName( self::RELATED_VIDEOS_VAR, $id, False );
				WikiFactory::clearCache( $id );
				$this->debug( "\tdone" );
			}

		}
	}

	function debug( $msg ) {
		if ( !$this->verbose ) {
			return;
		}
		echo "$msg\n";
	}
}

$maintClass = "disableRelatedVideosExt";
require_once( RUN_MAINTENANCE_IF_MAIN );

