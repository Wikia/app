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

		$status = ( bool ) $this->updateUserEmail( $userMap->getWikiaUserId(), $email );
		$this->info( 'Facebook user email update complete', [
			'title' => __METHOD__,
			'userid' => $userId,
			'facebookid' => $fbUserId,
			'email' => $email,
			'status' => ( $status ? 'success' : 'fail' ),
		] );

		return $status;
	}

	protected function updateUserEmail( $userId, $email ) {
		$app = \F::app();

		$dbw = wfGetDB( DB_MASTER, null, $app->wg->ExternalSharedDB );
		( new \WikiaSQL() )
			->UPDATE( 'user' )
			->SET( 'user_email', $email )
			->WHERE( 'user_id' )->EQUAL_TO( $userId )
			->run( $dbw );

		return $dbw->affectedRows();
	}

}
