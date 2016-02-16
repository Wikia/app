<?php
namespace Wikia\ExactTarget;

class ExactTargetDataHelper {
	/**
	 * Prepares array of params for ExactTarget API for creating DataExtension objects for user table
	 * Assumes $aUserData has user_id key that will be treated as filter to update data
	 * Creates an array of DataExtension objects based on passed parameters
	 * @param  array $aUserData  User key value array
	 * @return array An array of DataExtension objects
	 */
	public function prepareUsersUpdateParams( array $aUsersData ) {
		$aDE = [];
		foreach ( $aUsersData as $aUserData ) {

			/* Get Customer Keys specific for production or development */
			$aCustomerKeys = $this->getCustomerKeys();
			$sCustomerKey = $aCustomerKeys['user'];

			$userId = $this->extractUserIdFromData( $aUserData );
			$keys = [ 'user_id' => $userId ];

			$oDE = new \ExactTarget_DataExtensionObject();
			$oDE->CustomerKey = $sCustomerKey;

			if( isset( $aUserData ) ) {
				$aApiProperties = [];
				foreach ( $aUserData as $sKey => $sValue ) {
					$aApiProperties[] = $this->wrapApiProperty( $sKey, $sValue );
				}
				$oDE->Properties = $aApiProperties;
			}

			if( isset( $keys ) ) {
				$aApiKeys = [];
				foreach ( $keys as $sKey => $sValue ) {
					$aApiKeys[] = $this->wrapApiProperty( $sKey, $sValue );
				}
				$oDE->Keys = $aApiKeys;
			}

			$aDE[] = $oDE;

		};

		return $aDE;
	}

	/**
	 * Returns user_id element from $aUserData array and removes it from array
	 * This for API params preparation. Allows to use user_id separately as key
	 * and user data as update parameters without user_id
	 * @param array $aUserData key value data from user table
	 * @return int
	 */
	private function extractUserIdFromData( &$aUserData ) {
		$iUserId = $aUserData['user_id'];
		unset( $aUserData['user_id'] );
		return $iUserId;
	}

	/**
	 * Get Customer Keys
	 * CustomerKey is a key that indicates Wikia table reflected by DataExtension
	 */
	protected function getCustomerKeys() {
		$aCustomerKeys = [
			'user' => 'user',
			'user_properties' => 'user_properties',
			'user_groups' => 'user_groups',
			'UserID_WikiID' => 'UserID_WikiID'
		];
		return $aCustomerKeys;
	}

	/**
	 * Returns ExactTarget_APIProperty object
	 * This object can be used as ExactTarget_DataExtensionObject property
	 * It stores key-value pair
	 * @param String $key Property name
	 * @param String $value Propert yvalue
	 * @return ExactTarget_APIProperty
	 */
	public function wrapApiProperty( $key, $value ) {
		$apiProperty = new \ExactTarget_APIProperty();
		$apiProperty->Name = $key;
		$apiProperty->Value = $value;
		return $apiProperty;
	}
}
