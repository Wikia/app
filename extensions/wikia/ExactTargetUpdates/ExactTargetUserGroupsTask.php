<?php

class ExactTargetUserGroupsTask extends ExactTargetBaseTask {

	/**
	 * Task for creating a record with user group and user in ExactTarget
	 * @param int $iUserId
	 * @param string $sGroup name of added group
	 */
	public function addUserGroup( $iUserId, $sGroup ) {

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

}
