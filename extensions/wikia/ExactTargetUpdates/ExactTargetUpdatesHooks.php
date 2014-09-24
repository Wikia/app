<?php

class ExactTargetUpdatesHooks {

	/**
	 * Runs a method for adding AddUserTask to job queue
	 * Function executed on SignupConfirmEmailComplete hook
	 * @param User $user
	 * @return bool
	 */
	public static function onSignupConfirmEmailComplete( User $user ) {
		$thisInstance = new ExactTargetUpdatesHooks();
		$thisInstance->addTheAddUserTask( $user, new ExactTargetAddUserTask() );
		return true;
	}

	/**
	 * Runs a method for adding UpdateUserTask to job queue
	 * Function executed on UserSaveSettings hook
	 * @param User $user
	 * @return bool
	 */
	public static function onUserSaveSettings( User $user ) {
		$thisInstance = new ExactTargetUpdatesHooks();
		$thisInstance->addTheUpdateUserTask( $user, new ExactTargetUpdateUserTask() );
		return true;
	}

	public static function onWikiCreation( $aParams ) {
		$thisInstance = new ExactTargetUpdatesHooks();
		$thisInstance->addTheAddWikiTask( $aParams, new ExactTargetAddWikiTask() );
		return true;
	}

	/**
	 * Adds AddUserTask to job queue
	 * @param User $user
	 * @param ExactTargetAddUserTask $task
	 */
	public function addTheAddUserTask( User $user, ExactTargetAddUserTask $task ) {
		global $wgWikiaEnvironment;
		/* Don't add task when on dev or internal */
		if ( $wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL ) {
			$aUserData = $this->prepareUserParams( $user );
			$aUserProperties = $this->prepareUserPropertiesParams( $user );
			$task->call( 'sendNewUserData', $aUserData, $aUserProperties );
			$task->queue();
		}
	}

	/**
	 * Adds AddUserTask to job queue
	 * @param User $user
	 * @param ExactTargetAddUserTask $task
	 */
	public function addTheUpdateUserTask( User $user, ExactTargetUpdateUserTask $task ) {
		global $wgWikiaEnvironment;
		/* Don't add task when on dev or internal */
		if ( $wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL ) {
			$aUserData = $this->prepareUserParams( $user );
			$aUserProperties = $this->prepareUserPropertiesParams( $user );
			$task->call( 'updateUserData', $aUserData, $aUserProperties );
			$task->queue();
		}
	}

	/**
	 * Prepares array of user fields needed to be passed by API
	 * @param User $oUser
	 * @return array
	 */
	public function prepareUserParams( User $oUser ) {
		$aUserParams = [
			'user_id' => $oUser->getId(),
			'user_name' => $oUser->getName(),
			'user_real_name' => $oUser->getRealName(),
			'user_email' => $oUser->getEmail(),
			'user_email_authenticated' => $oUser->getEmailAuthenticationTimestamp(),
			'user_registration' => $oUser->getRegistration(),
			'user_editcount' => $oUser->getEditCount(),
			'user_touched' => $oUser->getTouched()
		];
		return $aUserParams;
	}

	/**
	 * Prepares array of user properties fields needed to be passed by API
	 * @param User $oUser
	 * @return array
	 */
	public function prepareUserPropertiesParams( User $oUser ) {
		$aUserPropertiesParams = [
			'marketingallowed' => $oUser->getOption( 'marketingallowed' ),
			'unsubscribed' => $oUser->getOption( 'unsubscribed' ),
			'language' => $oUser->getOption( 'language' )
		];
		return $aUserPropertiesParams;
	}

	public function addTheAddWikiTask( $aParams, ExactTargetAddWikiTask $oTask ) {
		global $wgWikiaEnvironment;
		/* Don't add task when on dev or internal */
		// if ( $wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL ) {
			$iCityId = $aParams['city_id'];
			$aWikiData = $this->prepareWikiParams( $iCityId );
			$aWikiCatsMappingData = $this->prepareWikiCatsMappingParams( $iCityId );
			$oTask->call( 'sendNewWikiData', $aWikiData, $aWikiCatsMappingData );
			$oTask->queue();
		// }
	}

	private function prepareWikiParams( $iCityId ) {
		$oWiki = \WikiFactory::getWikiById( $iCityId );

		$aWikiParams = [
			'city_id' => $oWiki->city_id,
			'city_path' => $oWiki->city_path,
			'city_sitename' => $oWiki->city_sitename,
			'city_url' => $oWiki->city_url,
			'city_created' => $oWiki->city_created,
			'city_founding_user' => $oWiki->city_founding_user,
		];
		return $aWikiParams;
	}

	private function prepareWikiCatsMappingParams( $iCityId ) {
		/* @var string sIncludeDepracated Used to retrieve a full mapping of a wiki */
		$sIncludeDepracated = 'skip';
		$aCategories = \WikiFactory::getCategories( $iCityId, $sIncludeDepracated );

		$aWikiCatsMappingParams = [];
		foreach( $aCategories as $aCategory ) {
			$aWikiCatsMappingParams[] = [
				'city_id' => $iCityId,
				'cat_id' => $aCategory->cat_id,
			];
		}
		return $aWikiCatsMappingParams;
	}
}
