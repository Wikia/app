<?php
/**
 * Maintenance script for updating user data in ExactTarget database of users that edited last day
 *
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 *
 */

require_once( __DIR__.'/../../../../maintenance/Maintenance.php' );

use Wikia\ExactTarget\ExactTargetUserHooksHelper;
use Wikia\ExactTarget\ExactTargetClient;

class ExactTargetUpdateUserGlobalEditCountMaintenance extends Maintenance {

	/**
	 * Maintenance script entry point.
	 * Gathering users' ids who edited last day and adding update task to job queue.
	 */
	public function execute() {
		global $wgDWStatsDB;
		$oStatsDBr = wfGetDB( DB_SLAVE, [], $wgDWStatsDB );
		$sStartDate = $this->getLastDayDate();
		$aUsersIds = $this->getListOfUsersIdsEdited( $oStatsDBr, $sStartDate );
		$aUsersData = $this->prepareUsersParams( $aUsersIds );
		$this->addUsersUpdateTasks( $aUsersData );
	}

	/**
	 * Fetches user ids from statsDB from last period determined by prepareTimeCondition function
	 * @param DatabaseBase $oStatsDBr
	 * @param string $sStartDate e.g. 2014-12-31
	 * @return array of user ids
	 */
	private function getListOfUsersIdsEdited( DatabaseBase $oStatsDBr, $sStartDate ) {
		// Get user edits
		$oWikiaSQL = new WikiaSQL();
		$oWikiaSQL->SELECT()
			->DISTINCT( 'user_id' )
			->FROM( 'rollup_wiki_user_events' )
			->WHERE( 'time_id' )->GREATER_THAN( $sStartDate )
			->AND_( 'period_id' )->EQUAL_TO( DataMartService::PERIOD_ID_DAILY )
			->AND_( 'user_id' )->NOT_EQUAL_TO( 0 );

		$aUsersIdsDidEdit = $oWikiaSQL->runLoop( $oStatsDBr, function( &$aUsersIdsDidEdit, $oUsersIdsDidEdit ) {
			$aUsersIdsDidEdit[] = $oUsersIdsDidEdit->user_id;
		} );
		return $aUsersIdsDidEdit;
	}

	/**
	 * Returns array of users data arrays
	 * user fields returned are defined by ExactTargetUserHooksHelper::prepareUserParams method
	 * @param array $aUsersIds array of user ids
	 * @return array
	 */
	private function prepareUsersParams( array $aUsersIds ) {
		$aUsersParams = [];
		foreach ( $aUsersIds as $iUserId ) {
			$oUser = User::newFromId( $iUserId );
			$oExactTargetUserHooksHelper = new ExactTargetUserHooksHelper();
			$aUsersParams[] = $oExactTargetUserHooksHelper->prepareUserParams( $oUser );
		}
		return $aUsersParams;
	}

	private function addUsersUpdateTasks( $aUsersData ) {
		$aUsersDataChunked = array_chunk( $aUsersData, ExactTargetClient::OBJECTS_PER_REQUEST_LIMIT );
		foreach ( $aUsersDataChunked as $aUsersDataChunk ) {
			$this->addUsersUpdateTask( $aUsersDataChunk );
		}
	}

	private function addUsersUpdateTask( $usersData ) {
		foreach ( $usersData as $userData ) {
			$task = new \Wikia\ExactTarget\ExactTargetUserTask();
			$task->call( 'updateUser', $userData );
			$task->queue();
		}
	}

	private function getLastDayDate() {
		$oNow = new DateTime();
		$oNow->sub( new DateInterval( 'P1D' ) );
		$sStartDate = $oNow->format( 'Y-m-d H:i:s' );
		return $sStartDate;
	}

}

$maintClass = "ExactTargetUpdateUserGlobalEditCountMaintenance";
require_once( RUN_MAINTENANCE_IF_MAIN );
