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

require_once( __DIR__ . "/../../../../maintenance/commandLine.inc" );

class ExactTargetUpdateUserEditsPerWikiMaintenance {

	private $aBotsList = NULL;

	/**
	 * Maintenance script entry point.
	 * Gathering user edits data from last day and adding update task to job queue.
	 * Script skips old TempUser relicts and bot accounts.
	 */
	public function execute() {
		global $wgDWStatsDB;
		// Get DB
		$oStatsDBr = wfGetDB( DB_SLAVE, array(), $wgDWStatsDB );
		$sStartDate = $this->getLastDayDate();
		$oUsersListResult = $this->getUsersEditedRecently( $oStatsDBr, $sStartDate );
		$aUsersEditsData = $this->getUserEdits( $oStatsDBr, $sStartDate, $oUsersListResult );
		$this->addEditsUpdateTask( $aUsersEditsData );
	}

	private function getUsersEditedRecently( $oStatsDBr, $sStartDate ) {
		$timeCondition = $this->prepareTimeCondition( $sStartDate );
		// Get list of users that made edits in last period
		$oUsersListResult = $oStatsDBr->query("SELECT distinct user_id from rollup_wiki_user_events where {$timeCondition} and user_id != 0;");
		return $oUsersListResult;
	}

	private function prepareTimeCondition( $sStartDate ) {
		return "time_id>'{$sStartDate}' and period_id=1";
	}

	/**
	 * Fetches user edits from statsDB from last period determined by prepareTimeCondition function
	 * e.g. result
	 * [ 12345 => [ 177 => 5 ] ]; It means user 12345 made 5 edits on 177 wiki
	 * @param $oStatsDBr
	 * @param $sStartDate
	 * @param $oUsersListResult
	 * @return array
	 */
	private function getUserEdits( $oStatsDBr, $sStartDate, $oUsersListResult ) {
		$timeCondition = $this->prepareTimeCondition( $sStartDate );
		// Get user edits
		$aUsersEditsData = [];
		foreach ( $oUsersListResult as $oUserResult ) {
			if ( !$this->isUserBot( $oUserResult->user_id ) ) {
				$oUserEditCountWikisResult = $oStatsDBr->query("SELECT user_id, wiki_id, ( sum( edits )+sum( creates ) ) as editcount from rollup_wiki_user_events where {$timeCondition} and user_id = {$oUserResult->user_id} group by wiki_id");
				foreach ( $oUserEditCountWikisResult as $oUserEditCountWikiResult ) {
					$aUsersEditsData[ $oUserEditCountWikiResult->user_id ][ $oUserEditCountWikiResult->wiki_id ] =
						intval( $oUserEditCountWikiResult->editcount );
				}
			}
		}
		return $aUsersEditsData;
	}

	private function isUserBot($uId) {
		$aBotsList = $this->getBotsIds();
		return array_key_exists( $uId, $aBotsList );
	}

	private function getBotsIds() {
		if ( $this->aBotsList === NULL ) {
			$this->loadBotsIds();
		}
		return $this->aBotsList;
	}

	private function loadBotsIds() {
		global $wgExternalSharedDB;
		$oExternalSharedDBr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$oBotsResult = $oExternalSharedDBr->query( "SELECT ug_user from user_groups where ug_group IN ('bot', 'bot-global');" );
		$this->aBotsList = [];
		foreach( $oBotsResult as $bot ) {
			$this->aBotsList[ $bot->ug_user ] = true;
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

$updateUserEditsPerWiki = new ExactTargetUpdateUserEditsPerWikiMaintenance();
$updateUserEditsPerWiki->execute();
