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
		$oUsersListResult = $this->getUsersEditedRecently( $oStatsDBr, $sStartDate );
		$aUsersEditsData = $this->getUserEdits( $oStatsDBr, $sStartDate, $oUsersListResult );
		$this->addEditsUpdateTask( $aUsersEditsData );
	}

	private function getUsersEditedRecently( DatabaseBase $oStatsDBr, $sStartDate ) {
		// Get list of users that made edits in last period
		$sql = ( new WikiaSQL() )
			->SELECT()
			->DISTINCT( 'user_id' )
			->FROM( 'rollup_wiki_user_events' )
			->WHERE( 'time_id' )->GREATER_THAN( $sStartDate )
			->AND_( 'period_id' )->EQUAL_TO( self::DAILY_PERIOD )
			->AND_( 'user_id' )->NOT_EQUAL_TO( 0 );

		/* @var ResultWrapper $oUsersListResult */
		$oUsersListResult = $sql->run( $oStatsDBr );

		return $oUsersListResult;
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
	private function getUserEdits( DatabaseBase $oStatsDBr, $sStartDate, $oUsersListResult ) {
		// Get user edits
		$aUsersEditsData = [];
		foreach ( $oUsersListResult as $oUserResult ) {
			$aUsersEditsData[ $oUserResult->user_id ] = ( new WikiaSQL() )
				->SELECT( 'user_id' )
					->FIELD( 'wiki_id' )
					->FIELD( 'sum( edits ) + sum( creates )' )->AS_( 'editcount' )
				->FROM( 'rollup_wiki_user_events' )
				->WHERE( 'time_id' )->GREATER_THAN( $sStartDate )
				->AND_( 'period_id' )->EQUAL_TO( self::DAILY_PERIOD )
				->AND_( 'user_id' )->EQUAL_TO( $oUserResult->user_id )
				->GROUP_BY( 'wiki_id' )
				->runLoop( $oStatsDBr, function( &$aUsersEditsOnWiki, $oUserEditCountWikiResult ) {
					$aUsersEditsOnWiki[ $oUserEditCountWikiResult->wiki_id ] =
						intval( $oUserEditCountWikiResult->editcount );
				});
		}
		return $aUsersEditsData;
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
