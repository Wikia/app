<?php

/**
 * Maintenance script to update navigation with Discussion links.
 * @author Michal 'slayful' Turek
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once(dirname(__FILE__) . '/../Maintenance.php');

/**
 * Class AddDiscussionsToNavigation
 */
class AddDiscussionsToNavigation extends Maintenance
{

	const VAR_NAME = 'wgOasisGlobalNavigation';
	const NAVIGATION_ELEMENT = '**Special:DiscussionsNavigation|Discussions';
	const FORUM_NAVIGATION_ELEMENT = '**Special:Forum|Forum';
	const REASON = 'SOC-2816 add Discussion navigation to the navigation';
	const SPLIT = "\r\n";

	private $dryRun = false;
	private $verbose = false;
	private $rollback = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Update " . self::VAR_NAME . " with Discussions navigation "
			. self::NAVIGATION_ELEMENT;
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'rollback', 'Rollback the operation', false, false, 'r' );
	}

	public function execute() {
		$this->dryRun = $this->hasOption( 'dry-run' );
		$this->verbose = $this->hasOption( 'verbose' );
		$this->rollback = $this->hasOption( 'rollback' );


		$total = 0;
		$successful = 0;
		foreach ($this->getAllSiteIds() as $siteId) {
			$success = $this->updateSiteId(trim($siteId));
			if ($success) {
				$successful++;
			}
			$total++;
		}

		echo "\nTotal sites: $total, Success: {$successful}, Failed: " . ($total - $successful) . "\n\n";
	}

	private function getAllSiteIds() {
		$siteIds = [];
		$db = WikiFactory::db( DB_MASTER );
		$sql = ( new WikiaSQL() )
			->SELECT( 'cv_city_id' )
			->FROM( 'city_variables' )
			->WHERE( 'cv_variable_id' )->EQUAL_TO( self::VAR_NAME );

		$sql->runLoop( $db, function( &$siteIds, $row ) {
			$siteIds[] = $row->cv_city_id;
			$this->debug('Added $row->cv_city_id');
		});

		return $siteIds;
	}

	private function updateSiteId($siteId) {
		$varData = (array)WikiFactory::getVarByName( self::VAR_NAME, $siteId, true );
		if ( empty( $varData['cv_id'] ) ) {
			$this->debug("Error:" . self::VAR_NAME . " not found.\n");
			return false;
		}

		if ( $varData['cv_variable_type'] !== 'text' ) {
			echo $varData['cv_variable_type'];
			die("Error: " . self::VAR_NAME . " is not a text and the script cannot append to it anything.\n");
		}

		echo "Variable: " . self::VAR_NAME . " (Id: $varData[cv_id])\n";
		$this->debug( "Variable data: " . json_encode( $varData ) . "\n");

		$value = $this->createNewValue( unserialize( $varData[ 'cv_value' ] ) );

		$result = false;
		if ( !$this->dryRun ) {
//			$this->setVariable( $siteId, $value, self::REASON );
		}
		return $result;
	}

	private function createNewValue( $previousValue ) {
		$this->debug( "Previous value:\n\n" . $previousValue );
		$array = explode( self::SPLIT, $previousValue );
		if ( !$this->rollback ) {
			$array = $this->insertBeforeForumOrAtTheEnd( $array );
		} else {
			$array = $this->removeNavigationElement( $array );
		}
		$newValue = join( self::SPLIT, $array );
		$this->debug( "New value\n\n:" . $newValue );
		return $newValue;
	}

	function insertBeforeForumOrAtTheEnd(&$array ) {
		$pos = array_search( self::FORUM_NAVIGATION_ELEMENT, $array );
		if ( $pos === false ) {
			$pos = count( $array ) - 1;
			$this->debug( "Forum not found - appending at the end.\n" );
		} else {
			$this->debug( "Found forum at $pos position.\n");
		}
		return array_merge(
			array_slice( $array, 0, $pos ),
			[ self::NAVIGATION_ELEMENT ],
			array_slice( $array, $pos )
		);
	}

	function removeNavigationElement( &$array ) {
		$pos = array_search( self::NAVIGATION_ELEMENT, $array );
		if ( $pos === false ) {
			$this->debug( "Discussion not found - not removing." );
			return $array;
		}
		$this->debug( "Discussion forum at $pos position." );
		array_splice( $array, $pos, 1 );
		return $array;
	}

	/**
	 * Print the message if verbose is enabled
	 * @param $msg
	 */
	protected function debug( $msg) {
		if ( $this->verbose ) {
			echo $msg;
		}
	}

}

$maintClass = "AddDiscussionsToNavigation";
require_once(RUN_MAINTENANCE_IF_MAIN);
