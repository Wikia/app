<?php

/**
* Maintenance script to update navigation with Discussion links.
* @author Michal 'slayful' Turek
*/

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

use \Wikia\Logger\WikiaLogger;

/**
 * Class AddDiscussionsToNavigation
 */
class AddDiscussionsToNavigation extends Maintenance {

	const VAR_NAME = 'wgOasisGlobalNavigation';
	const NAVIGATION_ELEMENT = '**Special:DiscussionsNavigation|Discussions';
	const FORUM_NAVIGATION_ELEMENT = '**Special:Forum|Forum';
	const REASON = 'SOC-2816';
	const SPLIT = '\n';

	private $dryRun  = false;
	private $verbose = false;
	private $rollback = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Update ".self::VAR_NAME." with Discussions navigation "
			.self::NAVIGATION_ELEMENT;
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'rollback', 'Rollback the operation', false, false, 'r');
	}

	public function execute() {
		$this->dryRun = $this->hasOption( 'dry-run' );
		$this->verbose = $this->hasOption( 'verbose' );
		$this->rollback = $this->hasOption( 'verbose' );


		$total = 0;
		$successful = 0;
		foreach ($this->getAllSiteIds() as $siteId) {
			$success = $this->updateSiteId( trim ( $siteId ) );
			if ($success) {
				$successful++;
			}
			$total++;
		}

		echo "\nTotal sites: $total, Success: {$successful}, Failed: ".( $total - $successful )."\n\n";
	}

	private function getAllSiteIds() {
		return [ 3035 ];
	}

	private function updateSiteId($siteId)
	{
		$varData = (array) WikiFactory::getVarByName( self::VAR_NAME, $siteId, true );
		if ( empty( $varData['cv_id'] ) ) {
			$this->debug( "Error:".self::VAR_NAME." not found.\n" );
		}

		if ($varData['cv_variable_type'] !== 'string' ) {
			die( "Error: self::VAR_NAME is not a string and the script cannot append to it anything.\n" );
		}

		echo "Variable: ".self::VAR_NAME." (Id: $varData[cv_id])\n";
		$this->debug( "Variable data: " . json_encode( $varData ) . "\n" );

		$value = $this->createNewValue(unserialize($varData['cv_value']));

		$result = false;
		if (!$this->dryRun) {
//			$this->setVariable( $siteId, $value, self::REASON );
		}
		return $result;
	}

	private function createNewValue($previousValue) {
		$this->debug( "Previous value ". $previousValue );
		$array = explode(self::SPLIT, $previousValue);
		$this->insertAfterForumOrAtTheEnd($array);
		$newValue = join(self::SPLIT, $array);
		$this->debug( "New value ". $previousValue );
		return $newValue;
	}

	function insertAfterForumOrAtTheEnd(&$array)
	{
		$pos   = array_search(self::FORUM_NAVIGATION_ELEMENT, $array);
		if ( $pos === false ) {
			$pos = count($array);
			$this->debug( "Forum not found appending at the end.");
		} else {
			$this->debug( "Found forum at $pos position.");
		}
		$array = array_merge(
			array_slice($array, 0, $pos),
			self::NAVIGATION_ELEMENT,
			array_slice($array, $pos)
		);
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

$maintClass = "AddDiscussionsToNavigation";
require_once( RUN_MAINTENANCE_IF_MAIN );
