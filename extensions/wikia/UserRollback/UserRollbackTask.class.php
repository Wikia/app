<?php
/**
 * UserRollbackTask
 *
 * Revert all revisions for specific users after some point in time
 *
 * @author Scott Rabin <srabin@wikia-inc.com>
 */

use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Tasks\AsyncTaskList;

class UserRollbackTask extends BaseTask {
	/**
	 * Find which communities contain revisions from the given users and batch
	 * tasks to revert those revisions
	 *
	 * This task should only run from community.wikia.com, where the UserRollback
	 * extension is enabled.
	 *
	 * @param array $users list of user names or IPs whose revisions should be reverted
	 * @param int $timestamp Unix time after which revisions should be reverted
	 * @param string $queue
	 */
	public function enqueueRollback( array $identifiers, $timestamp, $queue ) {
		$affectedWikis = $this->getAffectedWikis($identifiers);

		$taskLists = [ ];
		foreach ($affectedWikis as $wikiId => $usersOnWiki) {
			$task = new UserRollbackTask();
			$taskLists[ ] = ( new AsyncTaskList() )
				->wikiId( $wikiId )
				->setPriority( $queue )
				->add( $task->call('doRollback', $usersOnWiki, $timestamp) );
		}

		$result = [ ];
		if (!empty($taskLists)) {
			$result = AsyncTaskList::batch( $taskLists );
		}

		return $result;
	}

	/**
	 * Perform a rollback of all revisions published by the given user
	 * after the given time
	 *
	 * @param array $identifiers list of user names or IPs whose revisions should be reverted
	 * @param int $timestamp Unix time after which revisions should be reverted
	 */
	public function doRollback( array $identifiers, $timestamp ) {
		global $wgCityId, $IP;

		$phpScript = $IP . '/extensions/wikia/UserRollback/maintenance/rollbackEditsMulti.php';
		$cmd = sprintf("SERVER_ID=%d php {$phpScript} --users %s --time %s --onlyshared",
			$wgCityId, escapeshellarg(implode('|', $identifiers)), escapeshellarg($timestamp));

		$this->log( "Running {$cmd}" );
		$retval = wfShellExec( $cmd, $status );
		return $retval;
	}

	/**
	 * Find the wikis with revisions for the specified users
	 *
	 * @param array $identifiers
	 * @return array of wikiId => array of users with revisions on that wiki
	 */
	protected function getAffectedWikis( array $identifiers ) {
		global $wgStatsDB, $wgStatsDBEnabled, $wgDevelEnvironment;

		$wikiIds = [ ];
		if (!$wgStatsDBEnabled) {
			// requires stats database to function
			// TODO log this?
			return $wikiIds;
		}

		// on devbox we have to fall back to static list
		// because we have no active read-write statsdb there
		if ( !empty( $wgDevelEnvironment ) ) {
			global $wgCityId;
			return array(
				$wgCityId => $identifiers,
			);
		}

		$sdb = wfGetDB( DB_SLAVE, [ ], $wgStatsDB );
		foreach ($identifiers as $identifier) {
			list($userId, $ip) = $this->getUserByIdentifier($identifier);

			$affectedWikis = ( new WikiaSQL() )
				->DISTINCT( 'wiki_id' )
				->FROM( 'events' )
				->WHERE( 'user_id' )->EQUAL_TO( $userId );

			if ( $userId == 0 && isset($ip) ) {
				$affectedWikis->AND_( 'ip' )->EQUAL_TO( IP::toUnsigned($identifier) );
			}
			// TODO can userId be 0 and the identifier not be an IP?

			$wikis = $affectedWikis->runLoop($sdb, function($_, $row) use (&$wikiIds, $identifier) {
				if ( empty($wikiIds[$row->wiki_id]) ) {
					$wikiIds[$row->wiki_id] = [ ];
				}
				$wikiIds[$row->wiki_id][ ] = $identifier;
			});
		}

		return $wikiIds;
	}

	/**
	 * Determine the user ID and/or IP of a user given an identifier
	 *
	 * @param string $identifier
	 * @return array [userId, IP]
	 */
	protected function getUserByIdentifier( $identifier ) {
		$userId = 0;
		$userName = null;
		$ip = null;
		if ( User::isIP($identifier) ) {
			$ip = $identifier;
			$userName = $identifier;
		} else {
			$userName = User::getCanonicalName( $identifier );
		}

		if ( $userName !== false ) {
			$user = User::newFromName( $userName );
			if (!empty($user)) {
				$userId = $user->getId();
			}
		}

		return [$userId, $ip];
	}
}
