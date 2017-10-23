<?php

/**
* Maintenance script to manage WikiFactory variable for one wiki or multiple wikis (from file)
* - enable/disable the extension (set to true/false)
* - set value to the variable (only string, integer, boolean types)
* - remove variable from the wiki
* - get the variable value
* This is one time use script
* @usage
* 	# this will migrate wordmark-image-url for wiki with ID 119:
* 	migrateWikiWordmarks --dry-run --wiki 119 --verbose --keyName wordmark-image-url
*   # or
*   /usr/wikia/backend/bin/run_maintenance '--script=wikia/WikiFactoryVariables/migrateWikiWordmarks.php --dry-run --verbose --keyName wordmark-image-url' --id=119
*/

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

use \Wikia\Logger\WikiaLogger;

/**
 * Class MigrateWikiWordmarks
 */
class MigrateWikiWordmarks extends Maintenance {

	protected $dryRun  = false;
	protected $verbose = false;
	protected $keyName = '';
	const WIKI_FACTORY_VARIABLE = "wgOasisThemeSettings";

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Migrates variables in wgOasisThemeSettings to HTTPS";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'keyName', 'Key in WikiFactory variable which should be migrated to https', true, true, 'k' );
		$this->addOption( 'reason', 'Reason to provide when setting a variable', false, true );
	}

	public function execute() {
		global $wgCityId;
		$this->dryRun  = $this->hasOption( 'dry-run' );
		$this->verbose = $this->hasOption( 'verbose' );
		$this->keyName = $this->getOption( 'keyName', '' );
		$reason        = $this->getOption( 'reason' );

		if ( empty( $this->keyName ) ) {
			$this->error( "Error: Empty key name." . PHP_EOL );
			return false;
		}

		$varData = (array) WikiFactory::getVarByName( self::WIKI_FACTORY_VARIABLE, $wgCityId, true );
		if ( empty( $varData['cv_id'] ) ) {
			$this->error( "Error: " . self::WIKI_FACTORY_VARIABLE . " not found." . PHP_EOL );
			return false;
		}

		$this->output( "Variable: " . self::WIKI_FACTORY_VARIABLE . " (Id: $varData[cv_id])" . PHP_EOL );
		$this->debug( "Variable data: " . json_encode( $varData ) . PHP_EOL );

		$wg = F::app()->wg;
		$wg->User = User::newFromName( Wikia::BOT_USER );
		$wg->User->load();


		$this->output( "Updating {$this->keyName} in " . self::WIKI_FACTORY_VARIABLE . PHP_EOL );
		$prevValue = unserialize($varData['cv_value']);
		$keyValue = $prevValue[$this->keyName];

		if ( empty( $keyValue ) ) {
			$this->output( "Key is empty - skipping" . PHP_EOL );
			return false;
		}

		if ( strpos( $keyValue,"http://" ) !== 0 ) {
			$this->output( "Value doesn't start with 'http://' " . $keyValue .  " - skipping " . PHP_EOL );
			return false;
		}

		$replacements = 0;
		$keyValue = preg_replace( '#^http://#', "https://", $keyValue, 1, $replacements );

		if ( $replacements !== 1 ) {
			$this->output( "Value not changed " . $keyValue . "- skipping" . PHP_EOL );
			return false;
		}

		$prevValue[$this->keyName] = $keyValue;
		$this->debug("Setting " . self::WIKI_FACTORY_VARIABLE . " to " . var_export( $prevValue, true ) . PHP_EOL );
		$status = $this->setVariable( $wgCityId, $prevValue, $reason );

		if ( $this->dryRun || $status ) {
			$this->output(" ... DONE." . PHP_EOL );
		} else {
			$this->output( " ... FAILED." . PHP_EOL );
		}
	}

	/**
	 * Set the variable
	 * @param integer $wikiId
	 * @param mixed $varValue
	 * @param string $reason
	 * @return boolean
	 */
	protected function setVariable( $wikiId, $varValue, $reason ) {
		$status = false;
		if ( !$this->dryRun ) {
			$status = WikiFactory::setVarByName( self::WIKI_FACTORY_VARIABLE, $wikiId, $varValue, $reason );
			if ( $status ) {
				WikiFactory::clearCache( $wikiId );
			}
		} else {
			$this->output( "Dry run, not changing variable." . PHP_EOL );
		}

		return $status;
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

$maintClass = "MigrateWikiWordmarks";
require_once( RUN_MAINTENANCE_IF_MAIN );
