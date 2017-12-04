<?php

/**
* Maintenance script to manage WikiFactory variable to https
* @usage
* 	# this will migrate wgUploadPath for wiki with ID 119:
*   /usr/wikia/backend/bin/run_maintenance '--script=wikia/WikiFactoryVariables/migrateWikiFactoryToHttps.php --dry-run --varName wgUploadPath' --id=119
*/

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

use \Wikia\Logger\WikiaLogger;

/**
 * Class MigrateWikiFactoryToHttps
 */
class MigrateWikiFactoryToHttps extends Maintenance {

	protected $dryRun  = false;
	protected $verbose = false;
	protected $varName = '';

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Migrates Wiki Factory variable to HTTPS";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'varName', 'Name of the Wiki Factory variable', true, true, 'k' );
		$this->addOption( 'file', 'File where to save values that are going to be altered', false, true, 'f' );
	}

	public function execute() {
		global $wgCityId, $wgMedusaHostPrefix;
		$this->dryRun  = $this->hasOption( 'dry-run' );
		$this->varName = $this->getOption( 'varName', '' );
		$fileName = $this->getOption( 'file', false );

		if ( empty( $this->varName ) ) {
			$this->error( "Error: Variable name cannot be empty." . PHP_EOL );
			return false;
		}

		$varData = (array) WikiFactory::getVarByName( $this->varName, $wgCityId, true );
		if ( empty( $varData['cv_id'] ) ) {
			$this->error( "Error: " . $this->varName . " not found." . PHP_EOL );
			return false;
		}

		$fh = false;
		if ( $fileName ) {
			$fh = fopen( $fileName, "a" );
			if ( !$fh ) {
				$this->error( "Could not open file '$fileName' for write!'" . PHP_EOL );
				return false;
			}
		}

		$oldValue = $keyValue = $varData['cv_value'];

		if ( empty( $keyValue ) ) {
			$this->output( "Variable is empty for $wgCityId - skipping" . PHP_EOL );

			if ( $fh ) {
				fclose( $fh );
			}
			return false;
		}

		$this->output( "Updating {$this->varName} for " . $wgCityId . PHP_EOL );

		$keyValue = str_replace( 'http://', 'https://',
			str_replace( "//{$wgMedusaHostPrefix}images", '//' . str_replace( '.', '-', $wgMedusaHostPrefix ) . 'images', $keyValue ) );

		if ( $keyValue == $oldValue ) {
			$this->output( "Value not changed " . $keyValue . "- skipping" . PHP_EOL );

			if ( $fh ) {
				fclose( $fh );
			}
			return false;
		}

		$this->debug("Setting " . $this->varName . " to " . var_export( $keyValue, true ) . "for:". $wgCityId .PHP_EOL );
		if ( $fh ) {
			fwrite( $fh, sprintf("%d, \"%s\", \"%s\"\n", $wgCityId, $oldValue, $keyValue));
		}

		if ( !$this->dryRun ) {
			$globalStateWrapper = new Wikia\Util\GlobalStateWrapper( [
				'wgUser' => User::newFromName( Wikia::BOT_USER, false )
			] );

			WikiFactory::setVarByName( $this->varName, $wgCityId, $keyValue, "migrating Wiki Factory links to https" );
		}

		if ( $fh ) {
			fclose( $fh );
		}

		$this->output(" ... DONE." . PHP_EOL );
	}

	/**
	 * Print the message if verbose is enabled
	 * @param $msg
	 */
	protected function debug( $msg ) {
		if ( $this->verbose ) {
			$this->output( $msg );
		}
	}

}

$maintClass = "MigrateWikiFactoryToHttps";
require_once( RUN_MAINTENANCE_IF_MAIN );
