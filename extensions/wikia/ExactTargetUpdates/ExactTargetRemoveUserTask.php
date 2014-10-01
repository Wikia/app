<?php

class ExactTargetRemoveUserTask extends ExactTargetBaseTask {

	/**
	 * Task for removing user data in ExactTarget
	 * @param int $iUserId Id of user to be deleted
	 */
	public function removeUserData( $iUserId ) {
		$oClient = $this->getClient();
		$this->removeUserDataExtension( $iUserId, $oClient );
		$this->removeUserPropertiesDataExtension( $iUserId, $oClient );
	}

	/**
	 * Removes DataExtension object in ExactTarget by API request
	 * that reflects Wikia entry from user table
	 * @param int $iUserId
	 * @param ExactTargetSoapClient $oClient
	 */
	public function removeUserDataExtension( int $iUserId, ExactTargetSoapClient $oClient ) {

		try {
			$oDE = $this->prepareUserDataExtensionObjectForRemove( $iUserId );

			$oSoapVar = $this->wrapToSoapVar( $oDE );

			$oDeleteRequest = new ExactTarget_DeleteRequest();
			$oDeleteRequest->Objects = [ $oSoapVar ];
			$oDeleteRequest->Options = new ExactTarget_DeleteOptions();

			/* Send API delete request */
			$oClient->Delete( $oDeleteRequest );

			/* Log response */
			$this->info( $oClient->__getLastResponse() );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( 'SoapFault:' . $e->getMessage() . 'ErrorCode: ' . $e->getCode() );
		}
	}

	/**
	 * Removes DataExtension objects in ExactTarget by API request
	 * that reflects Wikia entry from user_properties table
	 * @param int $iUserId
	 * @param ExactTargetSoapClient $oClient
	 */
	public function removeUserPropertiesDataExtension( int $iUserId, ExactTargetSoapClient $oClient ) {

		try {
			$aDE = $this->prepareUserPropertiesDataExtensionObjectsForRemove( $iUserId );

			$aSoapVars = $this->prepareSoapVars( $aDE );

			$oDeleteRequest = new ExactTarget_DeleteRequest();
			$oDeleteRequest->Objects = $aSoapVars;
			$oDeleteRequest->Options = new ExactTarget_DeleteOptions();

			/* Send API delete request */
			$oClient->Delete( $oDeleteRequest );

			/* Log response */
			$this->info( $oClient->__getLastResponse() );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( 'SoapFault:' . $e->getMessage() . 'ErrorCode: ' . $e->getCode() );
		}
	}

	/**
	 * Prepares proper ExactTarget_DataExtensionObject object
	 * for sending remove request
	 * @param int $iUserId id of user to be removed
	 * @return ExactTarget_DataExtensionObject
	 */
	public function prepareUserDataExtensionObjectForRemove( int $iUserId ) {

		/* Create new DataExtensionObject that reflects user table data */
		$oDE = new ExactTarget_DataExtensionObject();
		/* CustomerKey is a key that indicates Wikia table reflected by DataExtension */
		$oDE->CustomerKey = 'user';

		/* Prepare query keys */
		$oDE->Keys = [ $this->wrapApiProperty( 'user_id',  $iUserId ) ];

		return $oDE;
	}

	/**
	 * Prepares array of proper ExactTarget_DataExtensionObject objects
	 * for sending remove request with user_properties to remove
	 * @param int $iUserId id of user to be removed
	 * @return ExactTarget_DataExtensionObject
	 */
	public function prepareUserPropertiesDataExtensionObjectsForRemove( int $iUserId ) {

		/*
		 * @var array $aUserPropertiesNames list of user properties sent to ExactTarget
		 * (see ExactTargetUpdatesHooks::prepareUserPropertiesParams)
		 */
		$aUserPropertiesNames = [
			'marketingallowed',
			'unsubscribed',
			'language'
		];

		$aDE = [];
		foreach ( $aUserPropertiesNames as $sPropertyName ) {
			/* Create new DataExtensionObject that reflects user table data */
			$oDE = new ExactTarget_DataExtensionObject();
			/* CustomerKey is a key that indicates Wikia table reflected by DataExtension */
			$oDE->CustomerKey = 'user_properties';

			/* Prepare query keys */
			$oDE->Keys = [
				$this->wrapApiProperty( 'up_user',  $iUserId ),
				$this->wrapApiProperty( 'up_property',  $sPropertyName )
			];

			$aDE[] = $oDE;
		}

		return $aDE;
	}

}
