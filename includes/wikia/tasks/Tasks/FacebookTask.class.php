<?php

/**
 * FacebookTask - Contains tasks related to Facebook
 */

namespace Wikia\Tasks\Tasks;

class FacebookTask extends BaseTask {

	/**
	 * Update User email to become Facebook-reported email
	 *
	 * @param int $userId
	 * @return bool
	 */
	public function updateEmailFromFacebook( $userId ) {
		$userMap = \FacebookMapModel::lookupFromWikiaID( $userId );
		if ( !$userMap ) {
			$this->error( 'Facebook user email update fail. Missing user mapping', [
				'title' => __METHOD__,
				'userid' => $userId,
			] );
			return false;
		}

		$fbUserId = $userMap->getFacebookUserId();
		$email = \FacebookClient::getInstance()->getEmail( $fbUserId );

		if ( !$email ) {
			$this->info( 'Facebook user email update: No Facebook email', [
				'title' => __METHOD__,
				'userid' => $userId,
				'facebookid' => $fbUserId,
			] );
			return false;
		}

		$this->updateUserEmail( $userMap->getWikiaUserId(), $email );
		$this->info( 'Facebook user email update complete', [
			'title' => __METHOD__,
			'userid' => $userId,
			'facebookid' => $fbUserId,
			'email' => $email,
		] );

		return true;
	}

	/**
	 * Update user email to the one given
	 *
	 * @param int $userId
	 * @param string $email
	 */
	protected function updateUserEmail( $userId, $email ) {
		/** @var \User $user */
		$user = \User::newFromId( $userId );
		$user->setEmail( $email );
		$user->confirmEmail();
		$user->saveSettings();
	}

}
