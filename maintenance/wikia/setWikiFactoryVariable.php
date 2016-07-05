<?php

/**
* Maintenance script to manage WikiFactory variable for one wiki or multiple wikis (from file)
* - enable/disable the extension (set to true/false)
* - set value to the variable (only string, integer, boolean types)
* - remove variable from the wiki
* - get the variable value
* This is one time use script
* @author Saipetch Kongkatong
*/

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

use \Wikia\Logger\WikiaLogger;

/**
 * Class SetWikiFactoryVariable
 */
class SetWikiFactoryVariable extends Maintenance {

	protected $dryRun  = false;
	protected $verbose = false;
	protected $varName = '';
	protected $action = '';
	protected $success = 0;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Set wiki factory variable";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'varName', 'WikiFactory variable name', true, true, 'n' );
		$this->addOption( 'set', 'Set the variable value. Note: "true" for enable or "false" for disable the extenstion', false, true, 's' );
		$this->addOption( 'remove', 'Remove the variable value (from the Wiki)', false, false, 'r' );
		$this->addOption( 'append', 'Append string value to existing value', false, false, 'a' );
		$this->addOption( 'merge', 'Merge new key into existing array value', false, false);
		$this->addOption( 'unset', 'Remove key from existing array value', false, false);
		$this->addOption( 'split', 'Convert a string value to an array to allow merge/unset options', false, false);
		$this->addOption( 'wikiId', 'Wiki Id', false, true, 'i' );
		$this->addOption( 'file', 'File of wiki ids', false, true, 'f' );
		$this->addOption( 'reason', 'Reaon to provide when setting a variable (--set is used)', false, true );
	}

	public function execute() {
		$this->dryRun = $this->hasOption( 'dry-run' );
		$this->verbose = $this->hasOption( 'verbose' );
		$this->varName = $this->getOption( 'varName', '' );
		$set = $this->hasOption( 'set' );
		$append = $this->hasOption( 'append' );
		$merge = $this->hasOption( 'merge' );
		$unset = $this->hasOption( 'unset' );
		$split = $this->getOption( 'split', '');
		$remove = $this->hasOption( 'remove' );
		$wikiId = $this->getOption( 'wikiId', '' );
		$file = $this->getOption('file', '');
		$reason = $this->getOption( 'reason' );

		if ( empty( $this->varName ) ) {
			die( "Error: Empty variable name.\n" );
		}

		if ( $set && $remove || $set && $append || $remove && $append ) {
			die( "Error: Cannot use one of the three commands (set, append, remove) at the same time" . PHP_EOL );
		}

		if( $set ) {
			$varValue = $this->getOption( 'set', '' );
		} else if ( $append ) {
			$varValue = $this->getOption( 'append', '' );
		} else if ( $merge ) {
			$varValue = $this->getOption( 'merge', '' );
		} else if ( $unset ) {
			$varValue = $this->getOption( 'unset', '' );
		}

		if ( ( $set || $append ) && $varValue == '' ) {
			die( "Error: Empty variable value.\n" );
		}

		if ( !empty( $wikiId ) ) {
			$wikiIds = [ $wikiId ];
		} else if ( !empty( $file ) ) {
			$wikiIds = file( $file );
		} else {
			die( "Error: wiki id is empty or the file is invalid.\n" );
		}

		$varData = (array) WikiFactory::getVarByName( $this->varName, $wikiId, true );
		if ( empty( $varData['cv_id'] ) ) {
			die( "Error: $this->varName not found.\n" );
		}

		if ( $append && $varData['cv_variable_type'] !== 'string' ) {
			die( "Error: $this->varName is not a string and the script cannot append to it anything.\n" );
		}

		echo "Variable: $this->varName (Id: $varData[cv_id])\n";
		$this->debug( "Variable data: " . json_encode( $varData ) . "\n" );

		// get valid value
		if ( $set ) {
			if ( $varValue == 'true' ) {
				$varValue = true;
			} else if ( $varValue == 'false' ) {
				$varValue = false;
			} else if ( is_numeric( $varValue ) ) {
				$varValue = intval( $varValue );
			}
		}

		$wg = F::app()->wg;
		$wg->User = User::newFromName( 'WikiaBot' );
		$wg->User->load();

		$cnt = 0;
		$total = count( $wikiIds );

		foreach ( $wikiIds as $id ) {
			$cnt++;
			$id = trim( $id );

			echo "Wiki $id [$cnt of $total]: ";

			$status = true;
			if ( $set ) {
				echo "Set {$this->varName} to " . var_export( $varValue, true );
				$status = $this->setVariable( $id, $varValue, $reason );
			} else if ( $append ) {
				echo "Appending " . $varValue . " to {$this->varName}:" . PHP_EOL;
				$varData = (array) WikiFactory::getVarByName( $this->varName, $id, true );
				$prevValue = unserialize($varData['cv_value']);
				$newValue = $prevValue . $varValue;
				echo "Previous value: " . $prevValue . PHP_EOL;
				echo "New value: " . $newValue . PHP_EOL;
				$status = $this->setVariable( $id, $newValue, $reason );
			} else if ( $merge ) {
				$varData = (array) WikiFactory::getVarByName( $this->varName, $id, true );
				if (!empty ($split)) {
					// value is string so we must convert to array
					$prevValue = unserialize($varData['cv_value']);
					$prevValue = explode($split, $prevValue);
				}

				if (is_array($prevValue)) {
					echo "Adding new value $varValue to array" . PHP_EOL;
					$newValue = array_filter(array_unique(array_merge($prevValue, [$varValue])));
				} else {
					echo "Value is not an array, you probably want to use the --split parameter." . PHP_EOL;
					$status = 0;  // failed, value is not an array
				}

				if (!empty ($split)) {
					// join array back to string
					$newValue = join($split, $newValue);
				}

				$status = $this->setVariable( $id, $newValue, $reason );

			} else if ( $unset ) {

				// NOT IMPLEMENTED YET
				echo "Not implemented yet." . PHP_EOL;

			} else if ( $remove ) {
				echo "Remove {$this->varName}";
				$status = $this->removeVariableFromWiki( $id, $varData );
			} else {
				echo $this->varName." = ".var_export( WikiFactory::getVarValueByName( $this->varName, $id ), true );
			}

			if ( $this->dryRun || $status ) {
				echo " ... DONE.\n";
				$this->success++;
			} else {
				echo " ... FAILED.\n";
			}
		}

		echo "\nTotal wikis: $total, Success: {$this->success}, Failed: ".( $total - $this->success )."\n\n";

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
			$status = WikiFactory::setVarByName( $this->varName, $wikiId, $varValue, $reason );
			if ( $status ) {
				WikiFactory::clearCache( $wikiId );
			}
		} else {
			echo "Dry run, not changing variable." . PHP_EOL;
		}

		return $status;
	}

	/**
	* Remove variable from the wiki
	* @param integer $wikiId
	* @param array $varData
	* @return boolean
	*/
	protected function removeVariableFromWiki( $wikiId, $varData ) {
		$status = true;
		if ( !$this->dryRun ) {
			$log = WikiaLogger::instance();
			$resp = WikiFactory::removeVarById( $varData['cv_id'], $wikiId );
			$logData = $varData + [ 'wikiId' => $wikiId ];
			if ( $resp ) {
				$log->info( "Remove variable from city_variables table.", $logData );
			} else {
				$log->error( "Cannot remove variable from city_variables table.", $logData );
				$status = false;
			}
		 }

		return $status;
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

$maintClass = "SetWikiFactoryVariable";
require_once( RUN_MAINTENANCE_IF_MAIN );
