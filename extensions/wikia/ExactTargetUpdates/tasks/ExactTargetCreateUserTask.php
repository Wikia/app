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
		$oDeleteUserTask->taskId( $this->getTaskId() );
		$oDeleteUserTask->deleteSubscriber( $aUserData['user_id'] );

		/* Create Subscriber with new email */
		$this->createSubscriber( $aUserData['user_email'] );

		/* Create User DataExtension with new email */
		$this->createUser( $aUserData );

		/* Create User Properties DataExtension with new email */
		$this->createUserProperties( $aUserData['user_id'], $aUserProperties );

		return 'OK';
	}

	/**
	 * Creates Subscriber object in ExactTarget by API request
	 * @param String $sUserEmail new subscriber email address
	 */
	public function createSubscriber( $sUserEmail ) {
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareSubscriberData( $sUserEmail );
		$oApiDataExtension = $this->getApiSubscriber();

		$createSubscriberResult = $oApiDataExtension->createRequest( $aApiParams );

		$this->info( __METHOD__ . ' OverallStatus: ' . $createSubscriberResult->OverallStatus );
		$this->info( __METHOD__ . ' result: ' . json_encode( (array)$createSubscriberResult ) );
	}

	/**
	 * Creates (or updates if already exists) DataExtension object in ExactTarget by API request that reflects Wikia user table
	 * @param Array $aUserData Selected fields from Wikia user table
	 */
	public function createUser( $aUserData ) {
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserUpdateParams( $aUserData );
		$oApiDataExtension = $this->getApiDataExtension();

		$oCreateUserResult = $oApiDataExtension->updateFallbackCreateRequest( $aApiParams );

		$this->info( __METHOD__ . ' OverallStatus: ' . $oCreateUserResult->OverallStatus );
		$this->info( __METHOD__ . ' result: ' . json_encode( (array)$oCreateUserResult ) );

		if ( $oCreateUserResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error on createUser: ' . $oCreateUserResult->Results->StatusMessage
			);
		}
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
		$oCreateUserPropertiesResult = $oApiDataExtension->updateFallbackCreateRequest( $aApiParams );

		$this->info( __METHOD__ . ' OverallStatus: ' . $oCreateUserPropertiesResult->OverallStatus );
		$this->info( __METHOD__ . ' result: ' . json_encode( (array)$oCreateUserPropertiesResult ) );

		if ( $oCreateUserPropertiesResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error on createUser: ' . $oCreateUserPropertiesResult->Results->StatusMessage
			);
		}
	}

}
