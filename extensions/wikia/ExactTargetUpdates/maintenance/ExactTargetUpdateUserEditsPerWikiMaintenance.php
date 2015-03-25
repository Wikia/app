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

class ExactTargetUpdateUserEditsPerWikiMaintenance extends Maintenance {

	const DAILY_PERIOD = 1;

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
	 * @return array
	 */
	private function getUserEdits( DatabaseBase $oStatsDBr, $sStartDate ) {
		// Get user edits
		$oWikiaSQL = new WikiaSQL();
		$oWikiaSQL->SELECT( 'user_id' )
			->FIELD( 'wiki_id' )
			->FIELD( 'sum( edits ) + sum( creates )' )->AS_( 'editcount' )
			->FROM( 'rollup_wiki_user_events' )
			->WHERE( 'time_id' )->GREATER_THAN( $sStartDate )
			->AND_( 'period_id' )->EQUAL_TO( self::DAILY_PERIOD )
			->AND_( 'user_id' )->NOT_EQUAL_TO( 0 )
			->GROUP_BY( 'wiki_id' )
			->GROUP_BY( 'user_id' );
		$aUsersEditsData = $oWikiaSQL->runLoop( $oStatsDBr, function( &$oUserResult, $oUserEditCountWikiResult ) {
			$oUserResult[ $oUserEditCountWikiResult->user_id ][ $oUserEditCountWikiResult->wiki_id ] =
				intval( $oUserEditCountWikiResult->editcount );
		});
		return $aUsersEditsData;
	}

	private function addEditsUpdateTasks( $aUsersEditsData ) {
		$aUsersEditsData = array_chunk( $aUsersEditsData, \Wikia\ExactTarget\ExactTargetApiDataExtension::OBJECTS_PER_REQUEST_LIMIT, true );
		foreach ( $aUsersEditsData as $aUsersEditsDataChunk ) {
			$this->addEditsUpdateTask($aUsersEditsDataChunk);
		}
	}
	private function addEditsUpdateTask( $aUsersEditsData ) {
		/* Get and run the task */
		$task = new \Wikia\ExactTarget\ExactTargetUpdateUserTask();
		$task->call( 'updateUsersEdits', $aUsersEditsData );
		$task->queue();
	}

	private function getLastDayDate() {
		$oNow = new DateTime();
		$oNow->sub(new DateInterval('P1D'));
		$sStartDate = $oNow->format('Y-m-d H:i:s');
		return $sStartDate;
	}
}

$maintClass = "ExactTargetUpdateUserEditsPerWikiMaintenance";
require_once( RUN_MAINTENANCE_IF_MAIN );
