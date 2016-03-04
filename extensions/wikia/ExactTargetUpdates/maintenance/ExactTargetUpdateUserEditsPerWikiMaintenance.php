<?php
/**
 * Maintenance script for updating number of edits made by user on a wiki
 * in ExactTarget database
 *
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 *
 */

require_once( __DIR__.'/../../../../maintenance/Maintenance.php' );

use Wikia\ExactTarget\ExactTargetClient;

class ExactTargetUpdateUserEditsPerWikiMaintenance extends Maintenance {

	/**
	 * Maintenance script entry point.
	 * Gathering user edits data from last day and adding update task to job queue.
	 */
	public function execute() {
		global $wgDWStatsDB;
		// Get DB
		$oStatsDBr = wfGetDB( DB_SLAVE, [], $wgDWStatsDB );
		$sStartDate = $this->getLastDayDate();
		$aUsersEditsData = $this->getUserEdits( $oStatsDBr, $sStartDate );
		$this->addEditsUpdateTasks( $aUsersEditsData );
	}

	/**
	 * Fetches user edits from statsDB from last period determined by prepareTimeCondition function
	 * e.g. result
	 * [ 12345 => [ 177 => 5 ] ]; It means user 12345 made 5 edits on 177 wiki
	 * @param DatabaseBase $oStatsDBr
	 * @param string $sStartDate e.g. 2014-12-31
	 * @param boolean|ResultWrapper $oUsersListResult
	 * @return array of number of edits with merged key consisted of user_id and wiki_id
	 * e.g.
	 * [
	 *  '12345@177' => 3,
	 *  '15432@177' => 2
	 * ]
	 * Means user 12345 edited 3 times on 177 wikia and user 15432 edited 2 times on 177 wikia
	 */
	private function getUserEdits( DatabaseBase $oStatsDBr, $sStartDate ) {
		// Get user edits
		$oWikiaSQL = new WikiaSQL();
		$oWikiaSQL->SELECT( 'user_id' )
			->FIELD( 'wiki_id' )
			->FIELD( 'sum( edits ) + sum( creates )' )->AS_( 'editcount' )
			->FROM( 'rollup_wiki_user_events' )
			->WHERE( 'time_id' )->GREATER_THAN( $sStartDate )
			->AND_( 'period_id' )->EQUAL_TO( DataMartService::PERIOD_ID_DAILY )
			->AND_( 'user_id' )->NOT_EQUAL_TO( 0 )
			->GROUP_BY( 'wiki_id' )
			->GROUP_BY( 'user_id' );

		$aUsersEditsData = $oWikiaSQL->runLoop( $oStatsDBr, function( &$aUserResult, $oUserEditCountWikiResult ) {
			$sMergedKey = $this->mergeKey( $oUserEditCountWikiResult->user_id, $oUserEditCountWikiResult->wiki_id );
			$aUserResult[ $sMergedKey ] = intval( $oUserEditCountWikiResult->editcount );
		});

		return $aUsersEditsData;
	}

	private function addEditsUpdateTasks( $aUsersEditsData ) {
		$aUsersEditsData = array_chunk( $aUsersEditsData, ExactTargetClient::OBJECTS_PER_REQUEST_LIMIT, true );
		foreach ( $aUsersEditsData as $aUsersEditsDataChunk ) {
			$aPreparedUsersEditsData = $this->prepareDataFormat( $aUsersEditsDataChunk );
			$this->addEditsUpdateTask( $aPreparedUsersEditsData );
		}
	}

	private function addEditsUpdateTask( $aUsersEditsData ) {
		/* Get and run the task */
		$task = new \Wikia\ExactTarget\ExactTargetUserTask();
		$task->call( 'updateUsersEdits', $aUsersEditsData );
		$task->queue();
	}

	private function getLastDayDate() {
		$oNow = new DateTime();
		$oNow->sub(new DateInterval('P1D'));
		$sStartDate = $oNow->format('Y-m-d H:i:s');
		return $sStartDate;
	}

	/**
	 * @param array $aUsersEditsDataChunk [ user_id@wiki_id => editcount ]
	 * e.g.
	 * [
	 *  '12345@177' => 3,
	 *  '15432@177' => 2
	 * ]
	 * Means user 12345 edited 3 times on 177 wikia and user 15432 edited 2 times on 177 wikia
	 * @return array
	 * e.g.
	 * [
	 *  '12345' => [ '177' => 3 ],
	 *  '15432' => [ '177' => 2 ]
	 * ]
	 */
	private function prepareDataFormat( $aUsersEditsDataChunk ) {
		$aUsersEditsData = [];
		foreach ( $aUsersEditsDataChunk as $sMergedKey => $iEditcount ) {
			$aUnmergedKeysAssoc = $this->unmergeKey( $sMergedKey );
			$iUserId = $aUnmergedKeysAssoc['user_id'];
			$iWikiId = $aUnmergedKeysAssoc['wiki_id'];
			$aUsersEditsData[$iUserId][$iWikiId] = $iEditcount;
		}
		return $aUsersEditsData;
	}

	private function mergeKey( $iUserId, $iWikiId ) {
		return $iUserId . '@' . $iWikiId;
	}

	private function unmergeKey( $sMergedKey ) {
		$aUnmergedKeysTemp = explode( '@', $sMergedKey );
		$aUnmergedKeysAssoc['user_id'] = $aUnmergedKeysTemp[0];
		$aUnmergedKeysAssoc['wiki_id'] = $aUnmergedKeysTemp[1];
		return $aUnmergedKeysAssoc;
	}
}

$maintClass = "ExactTargetUpdateUserEditsPerWikiMaintenance";
require_once( RUN_MAINTENANCE_IF_MAIN );
