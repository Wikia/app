<?php

/**
* Maintenance script to manage WikiFactory variable to https
* @usage
* 	# this will migrate wgUploadPath for wiki with ID 119:
*   /usr/wikia/backend/bin/run_maintenance '--script=wikia/WikiFactoryVariables/migrateWikiFactoryToHttps.php --dryRun --varName wgUploadPath' --id=119
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
	protected $fh;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Migrates Wiki Factory variable to HTTPS";
		$this->addOption( 'dryRun', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'varName', 'Name of the Wiki Factory variable', true, true, 'k' );
		$this->addOption( 'file', 'File where to save values that are going to be altered', false, true, 'f' );
	}

	public function __destruct()
	{
		if ( $this->fh ) {
			fclose( $this->fh );
		}
	}

	public function execute() {
		global $wgCityId, $wgMedusaHostPrefix;
		$this->dryRun  = $this->hasOption( 'dryRun' );
		$this->varName = $this->getOption( 'varName', '' );
		$fileName = $this->getOption( 'file', false );

		if ( empty( $this->varName ) ) {
			$this->error( "Error: Variable name cannot be empty." . PHP_EOL );
			return false;
		}

		$varData = WikiFactory::getVarValueByName( $this->varName, $wgCityId, true );
		if ( !$varData ) {
			$this->error( "Error: " . $this->varName . " not found." . PHP_EOL );
			return false;
		}

		if ( $fileName ) {
			$this->fh = fopen( $fileName, "a" );
			if ( !$this->fh ) {
				$this->error( "Could not open file '$fileName' for write!'" . PHP_EOL );
				return false;
			}
		}

		$oldValue = $keyValue = $varData;

		if ( empty( $keyValue ) ) {
			$this->output( "Variable is empty for $wgCityId - skipping" . PHP_EOL );
			return false;
		}

		$this->output( "Updating {$this->varName} for " . $wgCityId . PHP_EOL );

		$keyValue = str_replace( 'http://', 'https://',
			str_replace( "//{$wgMedusaHostPrefix}images", '//' . str_replace( '.', '-', $wgMedusaHostPrefix ) . 'images', $keyValue ) );

		if ( $keyValue == $oldValue ) {
			$this->output( "Value not changed " . $keyValue . "- skipping" . PHP_EOL );
			return false;
		}

		$this->output("Setting " . $this->varName . " to " . var_export( $keyValue, true ) . "for:". $wgCityId .PHP_EOL );
		if ( $this->fh ) {
			fwrite( $this->fh, sprintf("%d, \"%s\", \"%s\"\n", $wgCityId, $oldValue, $keyValue));
		}

		if ( !$this->dryRun ) {
			$globalStateWrapper = new Wikia\Util\GlobalStateWrapper( [
				'wgUser' => User::newFromName( Wikia::BOT_USER, false )
			] );

			$globalStateWrapper->wrap( function () use ( $wgCityId, $keyValue ) {
				WikiFactory::setVarByName( $this->varName, $wgCityId, $keyValue, "migrating Wiki Factory links to https" );
			} );
		}

		$this->output(" ... DONE." . PHP_EOL );
	}
}

$maintClass = "MigrateWikiFactoryToHttps";
require_once( RUN_MAINTENANCE_IF_MAIN );
