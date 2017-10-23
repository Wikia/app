<?php

/**
* Maintenance script to revert last change made by bot in wgOasisThemeSettings
*
* This is one time use script
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
	const WIKI_FACTORY_VARIABLE = "wgOasisThemeSettings";
	const WIKI_FACTORY_VARIABLE_HISTORY = "wgOasisThemeSettingsHistory";

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Reverts wgOasisThemeSettings to previous value (bot edit only)";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'reason', 'Reason to provide when setting a variable', false, true );
	}

	public function execute() {
		global $wgCityId;
		$this->dryRun  = $this->hasOption( 'dry-run' );
		$this->verbose = $this->hasOption( 'verbose' );
		$reason        = $this->getOption( 'reason' );

		$varData = (array) WikiFactory::getVarByName( self::WIKI_FACTORY_VARIABLE_HISTORY, $wgCityId, false );

		if ( empty( $varData['cv_id'] ) ) {
			$this->error( "Error: " . self::WIKI_FACTORY_VARIABLE_HISTORY . " not found." . PHP_EOL );
			return false;
		}

		$this->output( "Variable: " . self::WIKI_FACTORY_VARIABLE_HISTORY . " (Id: $varData[cv_id])" . PHP_EOL );
//		$this->debug( "Variable data: " . json_encode( $varData ) . PHP_EOL );

		$wg = F::app()->wg;
		$wg->User = User::newFromName( Wikia::BOT_USER );
		$wg->User->load();

		$this->output( "Reverting " . self::WIKI_FACTORY_VARIABLE . PHP_EOL );
		$prevValue = unserialize($varData['cv_value']);

		if ( empty( $prevValue ) ) {
			$this->output( "History empty - skipping" . PHP_EOL);
			return false;
		}

		$lastEntry = false;
		foreach ( $prevValue as $entry ) {
			if ( $entry['author'] == Wikia::BOT_USER && strpos($entry['timestamp'], '20171023') >= 0 ) {
				$lastEntry = $entry;
			}
		}


		if ( !$lastEntry ) {
			$this->output( 'Could not find proper history entry - skipping' . PHP_EOL );
			return false;
		} else {
			$this->debug('Author: "'. $lastEntry['author'] . '" timestamp: ' . $lastEntry['timestamp'] . PHP_EOL);
		}

		$this->debug("Setting " . self::WIKI_FACTORY_VARIABLE . " to " . var_export( $lastEntry['settings'], true ) . PHP_EOL );
//		$status = $this->setVariable( $wgCityId, $lastEntry['settings'], $reason );

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
