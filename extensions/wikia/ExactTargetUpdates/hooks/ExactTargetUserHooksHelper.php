<?php
namespace Wikia\ExactTarget;

class ExactTargetUserHooksHelper {
	/**
	 * Prepares array of user fields needed to be passed by API
	 * @param \User $oUser
	 * @return array
	 */
	public function prepareUserParams( \User $oUser ) {
		$aUserParams = [
			'user_id' => $oUser->getId(),
			'user_name' => $oUser->getName(),
			'user_real_name' => $oUser->getRealName(),
			'user_email' => $oUser->getEmail(),
			'user_email_authenticated' => $oUser->getEmailAuthenticationTimestamp(),
			'user_registration' => $oUser->getRegistration(),
			'user_editcount' => (int)$oUser->getEditCount(),
			'user_touched' => $oUser->getTouched()
		];
		return $aUserParams;
	}

	/**
	 * Prepares array of user properties fields needed to be passed by API
	 * @param \User $oUser
	 * @return array
	 */
	public function prepareUserPropertiesParams( \User $oUser ) {
		$aUserPropertiesParams = [
			'marketingallowed' => $oUser->getGlobalPreference( 'marketingallowed' ),
			'unsubscribed' => $oUser->getGlobalPreference( 'unsubscribed' ),
			'language' => $oUser->getGlobalPreference( 'language' )
		];
		return $aUserPropertiesParams;
	}
}
