<?php

class ExactTargetUserGroupsTask extends ExactTargetBaseTask {

	/**
	 * Task for creating a record with user group and user in ExactTarget
	 * @param int $iUserId
	 * @param string $sGroup name of added group
	 */
	public function addGroup( $iUserId, $sGroup ) {

		$oClient = $this->getClient();
		/* Create user_groups DataExtension for provided group and user */
		try {
			$oDE = $this->prepareUserGroupDataExtensionObject( $iUserId, $sGroup );
			$oSoapVar = $this->wrapToSoapVar( $oDE );
			$oRequest = $this->wrapCreateRequest( [ $oSoapVar ] );

			/* Send API request */
			$oClient->Create( $oRequest );

			/* Log response */
			$this->info( $oClient->__getLastResponse() );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( 'SoapFault:' . $e->getMessage() . 'ErrorCode: ' . $e->getCode() );
		}
	}

	/**
	 * Task for creating all necessary objects in ExactTarget related to newly created user
	 * @param int $iUserId Selected fields from Wikia user table
	 * @param string $sUserGroup Array of Wikia user gobal properties
	 */
	public function removeGroup( $iUserId, $sGroup ) {
		/* @var ExactTargetSoapClient $oClient */
		$oClient = $this->getClient();
		/* Create User DataExtension with new email */
		try {
			$oDE = $this->prepareUserGroupDataExtensionObjectForRemove( $iUserId, $sGroup );
			$oSoapVar = $this->wrapToSoapVar( $oDE );
			$oRequest = $this->wrapDeleteRequest( [ $oSoapVar ] );

			/* Send API request */
			$oClient->Delete( $oRequest );

			/* Log response */
			$this->info( $oClient->__getLastResponse() );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( 'SoapFault:' . $e->getMessage() . 'ErrorCode: ' . $e->getCode() );
		}
	}
	/**
	 * Prepares proper ExactTarget_DataExtensionObject for creating user_group record in ExactTarget
	 * @param int $iUserId
	 * @param string $sGroup
	 * @return ExactTarget_DataExtensionObject
	 */
	protected function prepareUserGroupDataExtensionObject( $iUserId, $sGroup ) {
		/* Create new DataExtensionObject that reflects user_properties table data */
		$oDE = new ExactTarget_DataExtensionObject();
		/* CustomerKey is a key that indicates Wikia table reflected by DataExtension */
		$oDE->CustomerKey = 'user_groups';

		/* @var $apiProperties Array of ExactTarget_APIProperty objects */
		$apiProperties = [
			$this->wrapApiProperty( 'ug_user',  $iUserId ),
			$this->wrapApiProperty( 'ug_group',  $sGroup )
		];

		$oDE->Properties = $apiProperties;
		return $oDE;
	}

	/**
	 * Prepares proper ExactTarget_DataExtensionObject object
	 * for sending remove request
	 * @param int $iUserId id of user to be removed
	 * @return ExactTarget_DataExtensionObject
	 */
	public function prepareUserGroupDataExtensionObjectForRemove( $iUserId, $sGroup ) {

		/* Create new DataExtensionObject that reflects user table data */
		$oDE = new ExactTarget_DataExtensionObject();
		/* CustomerKey is a key that indicates Wikia table reflected by DataExtension */
		$oDE->CustomerKey = 'user_groups';

		/* Prepare query keys */
		$oDE->Keys = [
			$this->wrapApiProperty( 'ug_user',  $iUserId ),
			$this->wrapApiProperty( 'ug_group',  $sGroup )
		];

		return $oDE;
	}







}
