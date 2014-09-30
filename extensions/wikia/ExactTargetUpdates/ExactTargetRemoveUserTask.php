<?php

class ExactTargetRemoveUserTask extends ExactTargetBaseTask {

	/**
	 * Task for removing user data in ExactTarget
	 * @param array $aUserData Selected fields from Wikia user table
	 */
	public function removeUserData( $oUser ) {
		$oClient = $this->getClient();
		$this->removeUserDataExtension( $oUser, $oClient );
	}

	/**
	 * Removes DataExtension object in ExactTarget by API request
	 * that reflects Wikia entry from user table
	 * @param User $oUser
	 * @param ExactTargetSoapClient $oClient
	 */
	public function removeUserDataExtension( User $oUser, ExactTargetSoapClient $oClient ) {

		try {
			$oDE = $this->prepareUserDataExtensionObjectForRemove( $oUser->getId() );

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
	 * Prepares proper ExactTarget_DataExtensionObject object
	 * for sending remove request
	 * @param int $iUserId id of user to be removed
	 * @return ExactTarget_DataExtensionObject
	 */
	public function prepareUserDataExtensionObjectForRemove( int $iUserId ) {

		/* Create new DataExtensionObject that reflects user table data */
		$oDE = new ExactTarget_DataExtensionObject();
		/* CustomerKey is a key that indicates Wikia table reflected by DataExtension */
		$oDE->CustomerKey = 'user_dev';

		/* Prepare query keys */
		$oDE->Keys = [ $this->wrapApiProperty( 'user_id',  $iUserId ) ];

		return $oDE;
	}

}
