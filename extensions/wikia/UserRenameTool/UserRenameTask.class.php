<?php
use Wikia\Tasks\Tasks\BaseTask;

class UserRenameTask extends BaseTask {
	const EMAIL_CONTROLLER = \Email\Controller\UserNameChangeController::class;

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
	 *		rename_fake_user_id => Repeated rename process special case (TODO: Don't know what this is)
	 *		phalanx_block_id => Phalanx login block ID
	 * @return bool
	 */
	public function renameUser( array $wikiCityIds, array $params ) {
		global $IP;

		$renameIP = !empty( $params['rename_ip'] );

		$loadBalancerFactory = wfGetLBFactory();
		$process = RenameUserProcess::newFromData( $params );
		$process->setLogDestination( \RenameUserProcess::LOG_BATCH_TASK, $this );
		$process->setRequestorUser();

		$noErrors = true;

		// ComSup wants the StaffLogger to keep track of renames...
		$this->staffLog(
			'start',
			$params,
			RenameUserHelper::getLog(
				'userrenametool-info-started',
				$params['requestor_name'],
				$params['rename_old_name'],
				$params['rename_new_name'],
				$params['reason'],
				[$this->getTaskId()]
			)
		);

		try {
			foreach ( $wikiCityIds as $cityId ) {
				/**
				 * execute maintenance script
				 */
				$cmd = sprintf( "SERVER_ID=%s php {$IP}/maintenance/wikia/RenameUser_local.php", $cityId );
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

				foreach ( $opts as $opt => $val ) {
					$cmd .= sprintf( ' --%s %s', $opt, escapeshellarg( $val ) );
				}

				if ( $renameIP ) {
					$cmd .= ' --rename-ip-address';
				}

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

				$this->staffLog(
					'log',
					$params,
					RenameUserHelper::getLogForWiki(
						$params['requestor_name'],
						$params['rename_old_name'],
						$params['rename_new_name'],
						$cityId,
						$params['reason'],
						$exitCode > 0
					)
				);

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

		$this->notifyUser(
			\User::newFromId( $params['requestor_id'] ),
			$params['rename_old_name'],
			$params['rename_new_name']
		);

		if ( !$renameIP ) {
			// mark user as renamed
			$renamedUser = \User::newFromName( $params['rename_new_name'] );
			$renamedUser->setGlobalFlag( 'wasRenamed', true );
			$renamedUser->saveSettings();

			if ( $params['notify_renamed'] ) {
				// send e-mail to the user that rename process has finished
				$this->notifyUser( $renamedUser, $params['rename_old_name'], $params['rename_new_name'] );
			}
		}

		if ( $noErrors ) {
			$this->staffLog(
				'finish',
				$params,
				RenameUserHelper::getLog(
					'userrenametool-info-finished',
					$params['requestor_name'],
					$params['rename_old_name'],
					$params['rename_new_name'],
					$params['reason'],
					[ $this->getTaskId() ]
				)
			);
		} else {
			$this->staffLog(
				'fail',
				$params,
				RenameUserHelper::getLog(
					'userrenametool-info-failed',
					$params['requestor_name'],
					$params['rename_old_name'],
					$params['rename_new_name'],
					$params['reason'],
					[$this->getTaskId()]
				)
			);
		}

		return $noErrors;
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
	 * Send an email to a user notifying them that a rename action completed
	 *
	 * @param User $user
	 * @param string $oldUsername
	 * @param string $newUsername
	 */
	protected function notifyUser( $user, $oldUsername, $newUsername ) {
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
