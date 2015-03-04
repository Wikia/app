<?php
namespace Wikia\ExactTarget;

class ExactTargetCreateUserTask extends ExactTargetTask {

	/**
	 * Control method of the task responsible for creating all necessary objects
	 * in ExactTarget related to newly created user
	 * @param array $aUserData Selected fields from Wikia user table
	 * @param array $aUserProperties Array of Wikia user gobal properties
	 */
	public function updateCreateUserData( array $aUserData, array $aUserProperties ) {
		/* Delete subscriber (email address) used by touched user */
		$oDeleteUserTask = $this->getDeleteUserTask();
		$deleteTaskResult = $oDeleteUserTask->deleteSubscriber( $aUserData['user_id'] );
		$this->info( 'deleteSubscriber OverallStatus: ' . $deleteTaskResult->OverallStatus );
		$this->info( 'deleteSubscriber result: ' . json_encode( (array)$deleteTaskResult ) );

		/* Create Subscriber with new email */
		$createSubscriberResult = $this->createSubscriber( $aUserData['user_email'] );
		$this->info( 'createSubscriber OverallStatus: ' . $createSubscriberResult->OverallStatus );
		$this->info( 'createSubscriber result: ' . json_encode( (array)$createSubscriberResult ) );

		/* Create User DataExtension with new email */
		$createUserResult = $this->createUser( $aUserData );
		$this->info( 'createUser OverallStatus: ' . $createUserResult->OverallStatus );
		$this->info( 'createUser result: ' . json_encode( (array)$createUserResult ) );

		/* Create User Properties DataExtension with new email */
		$createUserPropertiesResult =  $this->createUserProperties( $aUserData['user_id'], $aUserProperties );
		$this->info( 'createUserProperties OverallStatus: ' . $createUserPropertiesResult->OverallStatus );
		$this->info( 'createUserProperties result: ' . json_encode( (array)$createUserPropertiesResult ) );
		return (
			$createUserPropertiesResult->OverallStatus !== 'Error'
			&& $createUserResult->OverallStatus !== 'Error'
		);
	}

	/**
	 * Creates Subscriber object in ExactTarget by API request
	 * @param String $sUserEmail new subscriber email address
	 */
	public function createSubscriber( $sUserEmail ) {
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareSubscriberData( $sUserEmail );
		$oApiDataExtension = $this->getApiSubscriber();
		return $oApiDataExtension->createRequest( $aApiParams );
	}

	/**
	 * Creates (or updates if already exists) DataExtension object in ExactTarget by API request that reflects Wikia user table
	 * @param Array $aUserData Selected fields from Wikia user table
	 */
	public function createUser( $aUserData ) {
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserUpdateParams( $aUserData );
		$oApiDataExtension = $this->getApiDataExtension();
		return $oApiDataExtension->updateFallbackCreateRequest( $aApiParams );
	}

	/**
	 * Creates DataExtension object in ExactTarget by API request that reflects Wikia user_properties table
	 * @param Integer $iUserId User ID
	 * @param Array $aUserProperties key-value array ['property_name'=>'property_value']
	 */
	public function createUserProperties( $iUserId, array $aUserProperties ) {
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserPropertiesUpdateParams( $iUserId, $aUserProperties );
		$oApiDataExtension = $this->getApiDataExtension();
		return $oApiDataExtension->updateFallbackCreateRequest( $aApiParams );
	}


}
