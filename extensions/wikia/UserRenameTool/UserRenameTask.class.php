<?php
/**
 * UserRenameTask
 *
 * @author Scott Rabin <srabin@wikia-inc.com>
 */

use Wikia\Tasks\Tasks\BaseTask;

class UserRenameTask extends BaseTask {
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

		$renameIP = !empty($params['rename_ip']);

		$process = RenameUserProcess::newFromData( $params );
		$process->setLogDestination( \RenameUserProcess::LOG_BATCH_TASK, $this );
		$process->setRequestorUser();

		$noErrors = true;

		foreach ($wikiCityIds as $cityId) {
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

			foreach ($opts as $opt => $val) {
				$cmd .= sprintf( ' --%s %s', $opt, escapeshellarg($val) );
			}
			if ( $renameIP ) {
				$cmd .= ' --rename-ip-address';
			}

			$exitCode = null;
			$output = wfShellExec( $cmd, $exitCode );
			$logMessage = sprintf( "Rename user %s to %s on city id %s",
				$params['rename_old_name'], $params['rename_new_name'], $cityId);
			$logContext = [
				'command' => $cmd,
				'exitStatus' => $exitCode,
				'output' => $output,
			];
			if ( $exitCode > 0 ) {
				\Wikia\Logger\WikiaLogger::instance()->error($logMessage, $logContext);
				$noErrors = false;
			} else {
				\Wikia\Logger\WikiaLogger::instance()->info($logMessage, $logContext);
			}
		}

		// clean up pre-process setup
		$process->cleanup();

		$this->notifyUser(
			\User::newFromId( $params['requestor_id'] ),
			$params['rename_old_name'],
			$params['rename_new_name']
		);

		if ( !$renameIP ) {
			//mark user as renamed
			$renamedUser = \User::newFromName( $params['rename_new_name'] );
			$renamedUser->setOption('wasRenamed', true);
			$renamedUser->saveSettings();

			if ( $params['notify_renamed'] ) {
				//send e-mail to the user that rename process has finished
				$this->notifyUser( $renamedUser, $params['rename_old_name'], $params['rename_new_name'] );
			}
		}

		return $noErrors;
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
			$user->sendMail(
				wfMsgForContent('userrenametool-finished-email-subject', $oldUsername),
				wfMsgForContent('userrenametool-finished-email-body-text', $oldUsername, $newUsername),
				null, //from
				null, //replyto
				'UserRenameProcessFinishedNotification',
				wfMsgForContent('userrenametool-finished-email-body-html', $oldUsername, $newUsername)
			);
			\Wikia\Logger\WikiaLogger::instance()->info(
				"Rename user {$oldUsername} to {$newUsername}: email notification",
				[
					'to' => $user->getEmail(),
				]
			);
		} else {
			\Wikia\Logger\WikiaLogger::instance()->warning(
				"Rename user {$oldUsername} to {$newUsername}: no email address set for user"
			);
		}
	}
}
