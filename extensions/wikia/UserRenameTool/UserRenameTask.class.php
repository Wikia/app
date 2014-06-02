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
	 * @param array $params
	 *		requestor_id => ID of the user requesting this rename action
	 *		requestor_name => Name of the user requesting this rename action
	 *		rename_user_id => ID of the user to rename
	 *		rename_old_name => Current username of the user to rename
	 *		rename_new_name => New username for the user to rename
	 *		reason => Reason for requesting username change
	 *		rename_fake_user_id => Repeated rename process special case (TODO: Don't know what this is)
	 *		phalanx_block_id => Phalanx login block ID
	 */
	public function renameUser( array $params ) {
		global $wgCityId;

		$renameIP = !empty($params['rename_ip']);

		$process = RenameUserProcess::newFromData( $params );
		$process->setLogDestination( \RenameUserProcess::LOG_BATCH_TASK, $this );
		$process->setRequestorUser();

		try {
			// Rename user by IP address (for CoppaTool)
			if ( $renameIP ) {
				// validate IP rename
				foreach ( [$params['rename_old_name'], $params['rename_new_name']] as $ip ) {
					if ( !IP::isIPAddress($ip) ) {
						$this->log("Invalid IP provided to rename IP address: {$ip}");
						return false;
					}
				}
				$process->updateLocalIP();
			} else {
				$process->updateLocal();
			}
			$errors = $process->getErrors();
		} catch (Exception $e) {
			$errors = $process->getErrors();
			$errors[] = sprintf("Exception in updateLocal(): %s in %s at line %d",
				$e->getMessage(), $e->getFile(), $e->getLine());
		}

		// clean up pre-process setup
		$process->cleanup();

		if ( !empty($errors) ) {
			foreach ( $errors as $error ) {
				$this->log($error);
			}
		}
		// TODO - The original task sent a notification to the requestor and
		// renamed user (if not by IP) *always*; should it do that even if there
		// are errors?
		// notify requestor and renamed user
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

		return empty($errors);
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
			$this->log("Notification sent to: {$user->getEmail()}");
		} else {
			$this->log("Cannot send email, no email set for user: {$user->getName()}");
		}
	}
}
