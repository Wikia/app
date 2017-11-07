<?php
/**
 * UserRenameTask
 *
 * @author Scott Rabin <srabin@wikia-inc.com>
 */

use Wikia\Tasks\Tasks\BaseTask;

class UserRenameTask extends BaseTask {
	const EMAIL_CONTROLLER = \Email\Controller\UserNameChangeController::class;

	/**
	 * Shim compatibility with RenameUserProcess calling ->log on this object
	 *
	 * @param string $text
	 */
	public function log( $text ) {
		$this->info( $text );
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
