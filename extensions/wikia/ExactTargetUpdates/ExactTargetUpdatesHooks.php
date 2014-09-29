<?php

class ExactTargetUpdatesHooks {

	/**
	 * A private property determining if tasks should be created.
	 * Set to false for DEV or INTERNAL if the wgExactTargetDevelopmentMode
	 * global is set to false. Set to true otherwise.
	 * @var boolean bShouldAddTask
	 */
	private $bShouldAddTask;

	function __construct() {
		$this->checkIfShouldAddTask();
	}

	/**
	 * Sets a boolean $bShouldAddTask member.
	 * Should be set to false for DEV or INTERNAL enviroment,
	 * unless wgExactTargetDevelopmentMode is set to true.
	 */
	private function checkIfShouldAddTask() {
		global $wgWikiaEnvironment, $wgExactTargetDevelopmentMode;

		if ( ( $wgWikiaEnvironment == WIKIA_ENV_DEV || $wgWikiaEnvironment == WIKIA_ENV_INTERNAL ) && $wgExactTargetDevelopmentMode == false ) {
			$this->bShouldAddTask = false;
		} else {
			$this->bShouldAddTask = true;
		}
	}

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

	/**
	 * Runs a method for adding an AddWikiTask to job queue.
	 * Executed on CreateWikiLocalJob-complete hook.
	 * @param  array $aParams  Contains a wiki's id, url and title.
	 * @return true
	 */
	public static function onWikiCreation( $aParams ) {
		$thisInstance = new ExactTargetUpdatesHooks();
		$thisInstance->addTheAddWikiTask( $aParams, new ExactTargetAddWikiTask() );
		return true;
	}

	/**
	 * Runs a method for adding an UpdateWikiTask to job queue on change in WikiFactory.
	 * Executed on WikiFactoryChanged hook.
	 * @param  array $aWfVarParams  Contains a var's name, a wiki's id and a new value.
	 * @return true
	 */
	public static function onWikiFactoryChange( $aWfVarParams ) {
		$thisInstance = new ExactTargetUpdatesHooks();
		$thisInstance->addTheUpdateWikiTask( $aWfVarParams, new ExactTargetUpdateWikiTask() );
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

	/**
	 * Adds a task to job queue that sends
	 * a Create request to ExactTarget with data of a new wiki.
	 * @param  array $aParams  Contains wiki's id, url and title.
	 * @param  ExactTargetAddWikiTask $oTask  Task object.
	 */
	public function addTheAddWikiTask( $aParams, ExactTargetAddWikiTask $oTask ) {
		if ( $this->bShouldAddTask ) {
			$iCityId = $aParams['city_id'];
			$aWikiData = $this->prepareWikiParams( $iCityId );
			$aWikiCatsMappingData = $this->prepareWikiCatsMappingParams( $iCityId );
			$oTask->call( 'sendNewWikiData', $aWikiData, $aWikiCatsMappingData );
			$oTask->queue();
		}
	}

	/**
	 * Adds a task to job queue that sends
	 * an Update request to ExactTarget with a changed variable.
	 * @param  array $aWfVarParams  Contains var's name, city_id and a new value.
	 * @param  ExactTargetUpdateTask $oTask  Task object.
	 */
	public function addTheUpdateWikiTask( $aWfVarParams, ExactTargetUpdateWikiTask $oTask ) {
		if ( $this->bShouldAddTask ) {
			$sVarName = $aWfVarParams[0];
			$aWfVarsTriggeringUpdate = ExactTargetUpdatesHelper::getWfVarsTriggeringUpdate();
			if ( isset( $aWfVarsTriggeringUpdate[ $sVarName ] ) {
				$aWikiDataForUpdate = $this->prepareWikiParamsForUpdate( $aWfVarParams );
				$oTask->call( 'updateWikiData', $aWikiDataForUpdate );
				$oTask->queue();
			}
		}
	}

	/**
	 * Helper method returning an array of city_list fields based on wiki's id.
	 * @param  integer $iCityId  An ID of a wiki
	 * @return array  An array with all values sent to ExactTarget.
	 */
	private function prepareWikiParams( $iCityId ) {
		$oWiki = \WikiFactory::getWikiById( $iCityId );

		$aWikiParams = [
			'city_id' => $oWiki->city_id, // Not changeable
			'city_url' => $oWiki->city_url, // DONE
			'city_created' => $oWiki->city_created, // Not changeable
			'city_founding_user' => $oWiki->city_founding_user, // Not changeable
			'city_description' => $oWiki->city_description,
			'city_title' => $oWiki->city_title, // DONE
			'city_lang' => $oWiki->city_lang, // DONE
			'city_cluster' => $oWiki->city_cluster, // DONE
			'city_vertical' => $oWiki->city_vertical,
		];
		return $aWikiParams;
	}

	/**
	 * Helper method returning an array mapping a wiki to categories.
	 * @param  integer $iCityId  An ID of a wiki
	 * @return array  An array mapping a wiki to categories
	 */
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

	private function prepareWikiDataForUpdate( $aWfVarParams ) {
		$aWikiDataForUpdate = [];

		$sVarName = $aWfVarParams[0];
		$iCityId = $aWfVarParams[1];
		$mVarNewValue = $aWfVarParams[2];

		switch ( $sVarName ) {
			case 'wfServer':
				$wgScriptPath = \WikiFactory::getVarValueByName( 'wgScriptPath', $iCityId );
				$sCityUrl = $mVarNewValue . $wgScriptPath;
				$aWikiDataForUpdate['city_url'] = $sCityUrl;
				break;

			case 'wgSitename':
				$aWikiDataForUpdate['city_title'] = $mVarNewValue;
				break;

			case 'wgLanguageCode':
				$aWikiDataForUpdate['city_lang'] = $mVarNewValue;
				break;

			case 'wgDBcluster' :
				$aWikiDataForUpdate['city_cluster'] = $mVarNewValue;
				break;
		}

		return $aWikiDataForUpdate;
	}
}
