<?php
use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetCreateUserTask extends BaseTask {

	/**
	 * Control method of the task responsible for creating all necessary objects
	 * in ExactTarget related to newly created user
	 * @param array $aUserData Selected fields from Wikia user table
	 * @param array $aUserProperties Array of Wikia user gobal properties
	 */
	public function updateCreateUserData( $aUserData, $aUserProperties ) {
		/* Delete subscriber (email address) used by touched user */
		$oDeleteUserTask = $this->getDeleteUserTaskObject();
		$oDeleteUserTask->deleteSubscriber( $aUserData['user_id'] );
		/* Create Subscriber with new email */
		$this->createSubscriber( $aUserData['user_email'] );
		/* Create User DataExtension with new email */
		$this->createUserDataExtension( $aUserData );
		/* Create User Properties DataExtension with new email */
		$this->createUserPropertiesDataExtension( $aUserData['user_id'], $aUserProperties );
	}

	/**
	 * Creates Subscriber object in ExactTarget by API request
	 * @param String $sUserEmail new subscriber email address
	 */
	public function createSubscriber( $sUserEmail ) {
//		try {
//			/* ExactTarget_Subscriber */
//			$oSubscriber = new ExactTarget_Subscriber();
//			$oSubscriber->SubscriberKey = $sUserEmail;
//			$oSubscriber->EmailAddress = $sUserEmail;
//
//			/* Create the subscriber */
//			$oSoapVar = $this->wrapToSoapVar( $oSubscriber, 'Subscriber' );
//			$oRequest = $this->wrapCreateRequest( [ $oSoapVar ] );
//
//			/* Send API request */
//			$oClient->Create( $oRequest );
//
//			/* Log response */
//			$this->info( $oClient->__getLastResponse() );
//
//		} catch ( SoapFault $e ) {
//			/* Log error */
//			$this->error( 'SoapFault:' . $e->getMessage() . 'ErrorCode: ' . $e->getCode() );
//		}
	}

	/**
	 * Creates (or updates if already exists) DataExtension object in ExactTarget by API request that reflects Wikia user table
	 * @param Array $aUserData Selected fields from Wikia user table
	 */
	public function createUserDataExtension( $aUserData ) {
		$oHelper = $this->getHelper();
		$aApiParams = $oHelper->prepareApiCreateParams( [ $aUserData ], 'user' );
		$oApiDataExtension = $this->getApiDataExtension();
		$oApiDataExtension->createRequest( $aApiParams );
	}

	/**
	 * Creates DataExtension object in ExactTarget by API request that reflects Wikia user_properties table
	 * @param Integer $iUserId User ID
	 * @param Array $aUserProperties key-value array ['property_name'=>'property_value']
	 */
	public function createUserPropertiesDataExtension( $iUserId, $aUserProperties ) {
		$oHelper = $this->getHelper();
		$aDataExtensionsParams = $oHelper->prepareUserPropertiesCreateParams( $iUserId, $aUserProperties );
		$aApiParams = $oHelper->prepareApiCreateParams( $aDataExtensionsParams, 'user_properties' );
		$oApiDataExtension = $this->getApiDataExtension();
		$oApiDataExtension->createRequest( $aApiParams );
	}

	/**
	 * Returns an instance of ExactTargetApiDataExtension class
	 * @return ExactTargetApiDataExtension
	 */
	private function getApiDataExtension() {
		return new ExactTargetApiDataExtension();
	}

	/**
	 * Returns an instance of ExactTargetDeleteUserTask class
	 * @return ExactTargetDeleteUserTask
	 */
	private function getDeleteUserTaskObject() {
		return new ExactTargetDeleteUserTask();
	}

	/**
	 * Returns an instance of ExactTargetUserTaskHelper class
	 * @return ExactTargetUserTaskHelper
	 */
	private function getHelper() {
		return new ExactTargetUserTaskHelper();
	}
}
