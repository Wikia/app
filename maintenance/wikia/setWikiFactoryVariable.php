<?php

/**
* Maintenance script to set WikiFactory variable
* This is one time use script
* @author Saipetch Kongkatong
*/

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Class setWikiFactoryVariable
 */
class setWikiFactoryVariable extends Maintenance {

	protected $verbose = false;
	protected $dryRun  = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Set wiki factory variable";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'varName', 'WikiFactory variable name', false, true, 'n' );
		$this->addOption( 'set', 'set the variable. Note: "true" for enable or "false" for disable the extenstion', false, true, 's' );
		$this->addOption( 'wikiId', 'Wiki Id', false, true, 'i' );
		$this->addOption( 'file', 'File of wiki id', false, true, 'f' );
	}

	public function execute() {
		$this->dryRun = $this->hasOption( 'dry-run' );
		$this->verbose = $this->hasOption( 'verbose' );
		$varName = $this->getOption( 'varName', '' );
		$varValue = $this->getOption( 'set', '' );
		$wikiId = $this->getOption( 'wikiId', '' );
		$file = $this->getOption('file', '');

		if ( empty( $varName ) ) {
			die( "Error: Empty variable name.\n" );
		}

		if ( $varValue == '' ) {
			die( "Error: Empty variable value.\n" );
		}

		$varData = (array) WikiFactory::getVarByName( $varName, false, true );
		if ( empty( $varData['cv_id'] ) ) {
			die( "Error: $varName not found.\n" );
		}

		if ( $varValue == 'true' ) {
			$varValue = true;
		} else if ( $varValue == 'false' ) {
			$varValue = false;
		}

		echo "Variable: $varName (Id: $varData[cv_id])\n";
		$this->debug( "Variable data: ".json_encode( $varData )."\n" );

		if ( !empty( $wikiId ) ) {
			$wikiIds = [ $wikiId ];
		} else if ( !empty( $file ) ) {
			$wikiIds = file( $file );
		} else {
			die( "Error: wiki id is empty or the file is invalid.\n" );
		}

		$wg = F::app()->wg;
		$wg->User = User::newFromName( 'WikiaBot' );
		$wg->User->load();

		$cnt = 0;
		$failed = 0;
		$total = count( $wikiIds );

		foreach ( $wikiIds as $id ) {
			$cnt++;
			$id = trim( $id );

			echo "Wiki $id [$cnt of $total]: Set $varName to ".var_export( $varValue, true );

			if ( !$this->dryRun ) {
				WikiFactory::setVarByName( $varName, $id, $varValue );
				WikiFactory::clearCache( $id );
			}

			echo " ... DONE.\n";
		}

		echo "\nTotal wikis: ".$total.", Success: ".( $total - $failed ).", Failed: $failed\n\n";

	}

	/**
	 * Print the message if verbose is enabled
	 * @param $msg
	 */
	protected function debug( $msg ) {
		if ( $this->verbose ) {
			echo $msg;
		}
	}

}

$maintClass = "setWikiFactoryVariable";
require_once( RUN_MAINTENANCE_IF_MAIN );
