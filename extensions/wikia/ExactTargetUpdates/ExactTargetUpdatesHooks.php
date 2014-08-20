<?php

class ExactTargetUpdatesHooks {

	public static function onConfirmEmailComplete( User $user ) {
		global $wgWikiaEnvironment;
		if ($wgWikiaEnvironment == WIKIA_ENV_PROD) {
			$aParams = self::prepareParams( $user );
			$task = new ExactTargetAddUserTask();
			$task->call( 'sendNewUserData', $aParams );
			$task->queue();
		}
		return true;
	}

	public function prepareParams( User $oUser ) {
		$aUserParams =[];
		$aUserParams[ 'user_id' ] = $oUser->getId();
		$aUserParams[ 'user_name' ] = $oUser->getName();
		$aUserParams[ 'user_real_name' ] = $oUser->getRealName();
		$aUserParams[ 'user_email' ] = $oUser->getEmail();
		$aUserParams[ 'user_email_authenticated' ] = $oUser->getEmailAuthenticationTimestamp();
		$aUserParams[ 'user_registration' ] = $oUser->getRegistration();
		$aUserParams[ 'user_editcount' ] = $oUser->getEditCount();
		$aUserParams[ 'user_options' ] = $oUser->getOptions();
		$aUserParams[ 'user_touched' ] = $oUser->getTouched();
		return $aUserParams;
	}
}
