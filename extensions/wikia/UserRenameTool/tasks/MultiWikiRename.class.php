<?php

namespace UserRenameTool\Tasks;

use Email\Controller\UserNameChangeController;
use Wikia\Tasks\Queues\PriorityQueue;

class MultiWikiRename extends WikiRenameBase {
	const EMAIL_CONTROLLER = UserNameChangeController::class;

	// How often to check for completed renames
	const TASK_POLL_SECONDS = 5;

	// How long to wait for a single wiki rename tasks to finish
	const TASK_MAX_WAIT = 1800;

	private $cityIds;
	private $startTime = 0;
	private $success = false;

	/**
	 * Marshal & execute the RenameUserProcess functions to rename a user
	 *
	 * @param array $cityIds
	 * @param array $params See comment in WikiRenameBase::params for more details.
	 *
	 * @return bool
	 */
	public function run( array $cityIds, array $params ) {
		$this->cityIds = $cityIds;
		$this->params = $params;

		$this->startTime = time();

		$this->setupProcessLocal();
		$this->process->logStartToStaff( $this->getTaskId() );

		try {
			$task = ( new SingleWikiRename() )->setPriority( PriorityQueue::NAME );
			foreach ( $cityIds as $cityId ) {
				$task->call( 'run', $cityId, $params );
				$task->queue();
			}
		} catch ( \Exception $e ) {
			$this->error( "error while creating SingleWikiRename tasks", [
				'message' => $e->getMessage(),
				'stack' => $e->getTraceAsString(),
			] );
			return false;
		}

		$this->monitorTasks();

		return $this->cleanup();
	}

	/**
	 * Keep track of the tasks created to rename the user on each individual wiki.  Each local task
	 * will update a user flag noting that the rename completed on that wiki.  See the
	 * method WikiaRenameBase::recordWikiRenamed for more details.
	 */
	private function monitorTasks() {
		// If we're restarting a rename, there will still be data here we can use to start where we left off
		$leftToRename = $this->getWikisLeftToUpdate();
		$leftToRename = empty( $leftToRename ) ? $this->cityIds : $leftToRename;

		while ( count( $leftToRename ) ) {
			$leftToRename = $this->checkStatus( $leftToRename );
			$this->recordWikisLeftToUpdate( $leftToRename );
			sleep( self::TASK_POLL_SECONDS );

			if ( $this->shouldGiveUpWaiting() ) {
				$this->process->logError( "Rename process aborted waiting for tasks to complete" );
				// Return leaving success as its default false value
				return;
			}
		}

		$this->success = true;
	}

	/**
	 * If a local rename task dies and doesn't update user flag indicated a completed status
	 * we could end up waiting forever here.  Break out after a predetermined amount of time
	 * based on self::TASK_MAX_WAIT
	 *
	 * @return bool
	 */
	private function shouldGiveUpWaiting() {
		$now = time();
		return ( $now - $this->startTime ) > self::TASK_MAX_WAIT;
	}

	/**
	 * Check each wiki ID given in leftToRename and see if that rename completed.  Return the new list of
	 * wiki IDs yet to be renamed.
	 *
	 * @param array $leftToRename
	 * @return array
	 */
	private function checkStatus( $leftToRename ) {
		$remaining = [];

		foreach ( $leftToRename as $wikiId ) {
			if ( !$this->checkWikiRenamed( $wikiId ) ) {
				$remaining[] = $wikiId;
			}
		}

		return $remaining;
	}

	/**
	 * Check if all wikis were successfully renamed.  If not, log the failure and return a false value,
	 * possibly triggering the tasks system to retry this task.  If its successful, log success and update
	 * some user values.
	 *
	 * @return bool
	 */
	private function cleanup() {
		if ( !$this->success ) {
			$this->process->logFailToStaff( $this->getTaskId() );
			return false;
		}

		// clean up pre-process setup
		$this->process->cleanupFakeUser();

		$this->notifyUser( \User::newFromId( $this->params['requestor_id'] ) );

		if ( empty( $this->params['rename_ip'] ) ) {
			// mark user as renamed
			$renamedUser = \User::newFromName( $this->params['rename_new_name'] );
			$renamedUser->setGlobalFlag( 'wasRenamed', true );
			$renamedUser->saveSettings();

			if ( $this->params['notify_renamed'] ) {
				// send e-mail to the user that rename process has finished
				$this->notifyUser( $renamedUser );
			}
		}

		$this->process->logFinishToStaff( $this->getTaskId() );
		$this->process->logInfo( "Rename process finished" );
		return true;
	}

	/**
	 * Send an email to a user notifying them that a rename action completed
	 *
	 * @param \User $user
	 */
	protected function notifyUser( $user ) {
		$oldUsername = $this->params['rename_old_name'];
		$newUsername = $this->params['rename_new_name'];

		if ( $user->getEmail() != null ) {
			\F::app()->sendRequest( self::EMAIL_CONTROLLER, 'handle', [
				'targetUser' => $user,
				'oldUserName' => $oldUsername,
				'newUserName' => $newUsername
			] );
			$this->info( 'rename user with email notification', [
				'old_name' => $oldUsername,
				'new_name' => $newUsername,
				'email' => $user->getEmail(),
			] );
		} else {
			$this->warning( 'no email address set for user', [
				'old_name' => $oldUsername,
				'new_name' => $newUsername,
			] );
		}
	}
}
