<?php
use Wikia\Tasks\Tasks\BaseTask;

class UserRenameToolTask extends BaseTask {
	const SCRIPT_TEMPLATE = "SERVER_ID=%s php %s/maintenance/wikia/RenameUser_local.php %s";
	const EMAIL_CONTROLLER = \Email\Controller\UserNameChangeController::class;
	const LOG_TYPE = 'renameuser';

	const ACTION_FAIL = 'fail';
	const ACTION_START = 'start';
	const ACTION_FINISH = 'finish';
	const ACTION_LOG = 'log';
	/**
	 * Marshal & execute the RenameUserProcess functions to rename a user
	 *
	 * @param array $wikiCityIds
	 * @param array $params
	 *		requestor_id => ID of the user requesting this rename action
	 *		requestor_name => Name of the user requesting this rename action
	 *		rename_user_id => ID of the user to rename
	 *		rename_old_name => Current username of the user to rename
	 *		rename_new_name => New username for the user to rename
	 *		reason => Reason for requesting username change
	 *		rename_fake_user_id => The ID of the fake account created with the old user name.
	 *                             See UserRenameToolProcess::createFakeUser
	 *		phalanx_block_id => Phalanx login block ID
	 * @return bool
	 */
	public function renameUser( array $wikiCityIds, array $params ) {
		global $IP;

		$loadBalancerFactory = wfGetLBFactory();
		$process = UserRenameToolProcessLocal::newFromData( $params );
		$process->setLogDestination( \UserRenameToolProcess::LOG_BATCH_TASK, $this );
		$process->setRequestorUser();

		$noErrors = true;

		// ComSup wants the StaffLogger to keep track of renames...
		$this->logStart( $params );

		try {
			$opts = $this->getShellOptions( $params );
			foreach ( $wikiCityIds as $cityId ) {
				// Run the maintenance script for each wiki
				$cmd = sprintf( self::SCRIPT_TEMPLATE, $cityId, $IP, $opts );

				$exitCode = null;

				$output = wfShellExec( $cmd, $exitCode );
				$logMessage = sprintf( "Rename user %s to %s on city id %s",
					$params['rename_old_name'], $params['rename_new_name'], $cityId );
				$logContext = [
					'command' => $cmd,
					'exitStatus' => $exitCode,
					'output' => $output,
				];

				if ( $exitCode > 0 ) {
					$this->error( $logMessage, $logContext );
					$noErrors = false;
				} else {
					$this->info( $logMessage, $logContext );
				}

				$this->logCityFinish( $params, $cityId, $exitCode );

				$loadBalancerFactory->forEachLBCallMethod( 'commitMasterChanges' );
				$loadBalancerFactory->forEachLBCallMethod( 'closeAll' );
			}
		} catch ( Exception $e ) {
			$noErrors = false;
			$this->error( "error while renaming user", [
				'message' => $e->getMessage(),
				'stack' => $e->getTraceAsString(),
			] );
		}

		// clean up pre-process setup
		$process->cleanup();

		$this->notifyUser( \User::newFromId( $params['requestor_id'] ), $params );

		if ( empty( $params['rename_ip'] ) ) {
			// mark user as renamed
			$renamedUser = \User::newFromName( $params['rename_new_name'] );
			$renamedUser->setGlobalFlag( 'wasRenamed', true );
			$renamedUser->saveSettings();

			if ( $params['notify_renamed'] ) {
				// send e-mail to the user that rename process has finished
				$this->notifyUser( $renamedUser, $params );
			}
		}

		if ( $noErrors ) {
			$this->logFinish( $params );
		} else {
			$this->logFailure( $params );
		}

		return $noErrors;
	}

	protected function getShellOptions( $params ) {
		$renameIP = !empty( $params['rename_ip'] );

		$opts = [
			'rename-user-id' => $params['rename_user_id'],
			'requestor-id' => $params['requestor_id'],
			'reason' => $params['reason'],
		];

		if ( $renameIP ) {
			$opts['rename-old-name'] = $params['rename_old_name'];
			$opts['rename-new-name'] = $params['rename_new_name'];
		} else {
			$opts['rename-old-name-enc'] = rawurlencode( $params['rename_old_name'] );
			$opts['rename-new-name-enc'] = rawurlencode( $params['rename_new_name'] );
			$opts['rename-fake-user-id'] = $params['rename_fake_user_id'];
			$opts['phalanx-block-id'] = $params['phalanx_block_id'];
		}

		$optString = '';
		foreach ( $opts as $opt => $val ) {
			$optString .= sprintf( ' --%s %s', $opt, escapeshellarg( $val ) );
		}

		// Include value-less options
		if ( $renameIP ) {
			$optString .= ' --rename-ip-address';
		}

		return $optString;
	}

	protected function logStart( $params ) {
		$this->staffLog(
			self::ACTION_START,
			$params,
			UserRenameToolHelper::getLog(
				'userrenametool-info-started',
				$params['requestor_name'],
				$params['rename_old_name'],
				$params['rename_new_name'],
				$params['reason'],
				[ $this->getTaskId() ]
			)
		);
	}

	protected function logCityFinish( $params, $cityId, $exitCode ) {
		$this->staffLog(
			self::ACTION_LOG,
			$params,
			UserRenameToolHelper::getLogForWiki(
				$params['requestor_name'],
				$params['rename_old_name'],
				$params['rename_new_name'],
				$cityId,
				$params['reason'],
				$exitCode > 0
			)
		);
	}

	protected function logFinish( $params ) {
		$this->staffLog(
			self::ACTION_FINISH,
			$params,
			UserRenameToolHelper::getLog(
				'userrenametool-info-finished',
				$params['requestor_name'],
				$params['rename_old_name'],
				$params['rename_new_name'],
				$params['reason'],
				[ $this->getTaskId() ]
			)
		);
	}

	protected function logFailure( $params ) {
		$this->staffLog(
			self::ACTION_FAIL,
			$params,
			UserRenameToolHelper::getLog(
				'userrenametool-info-failed',
				$params['requestor_name'],
				$params['rename_old_name'],
				$params['rename_new_name'],
				$params['reason'],
				[$this->getTaskId()]
			)
		);
	}

	/**
	 * Curry the StaffLogger function
	 *
	 * @param string $action Which action to log ('start', 'complete', 'fail', 'log')
	 * @param array $params The params given to `#renameUser`
	 * @param string $text The text to log
	 */
	protected function staffLog( $action, array $params, $text ) {
		\StaffLogger::log(
			'renameuser',
			$action,
			$params['requestor_id'],
			$params['requestor_name'],
			$params['rename_user_id'],
			$params['rename_new_name'],
			$text
		);
	}

	/**
	 * Shim compatibility with RenameUserProcess calling ->log on this object
	 *
	 * This happens in UserRenameToolProcess::addInternalLog
	 *
	 * @param string $text
	 */
	public function log( $text ) {
		$this->info( $text );
	}

	/**
	 * Send an email to a user notifying them that a rename action completed
	 *
	 * @param User $user
	 * @param array $params
	 */
	protected function notifyUser( $user, $params ) {
		$oldUsername = $params['rename_old_name'];
		$newUsername = $params['rename_new_name'];

		if ( $user->getEmail() != null ) {
			F::app()->sendRequest( self::EMAIL_CONTROLLER, 'handle', [
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
