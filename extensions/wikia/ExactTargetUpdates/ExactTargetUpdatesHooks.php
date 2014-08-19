<?php

class ExactTargetUpdatesTaskHooks {

	public static function onConfirmEmailComplete( User &$user ) {
		$aParams = self::prepareParams( $user );
		$task = new ExactTargetUpdatesTask();
		$task->call( 'sendNewUserData', $aParams );
		$task->queue();
	}

	private function prepareParams( User $oUser ) {
		$aUserParams =[];
		$aUserParams[ 'user_id' ] = $oUser->getId();
		$aUserParams[ 'user_name' ] = $oUser->getName();
		$aUserParams[ 'user_real_name' ] = $oUser->getRealName();
		$aUserParams[ 'user_email' ] = $oUser->getEmail();
		$aUserParams[ 'user_email_authenticated' ] = $oUser->getEmailAuthenticationTimestamp();
		$aUserParams[ 'user_registration' ] = $oUser->getRegistration();
		$aUserParams[ 'user_editcount' ] = $oUser->getEditCount();
		$aUserParams[ 'user_options' ] = $oUser->getOptions();
		$aUserParams[ 'user_options' ] = $oUser->setOptions();
		$aUserParams[ 'user_touched' ] = $oUser->getTouched();
		return $aUserParams;
	}
}
