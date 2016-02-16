<?php
namespace Wikia\ExactTarget;

use Wikia\Util\Assert;

class ExactTargetDataHelper {
	const CUSTOMER_KEY_USER = 'user';
	const EXACT_TARGET_USER_ID_PROPERTY = 'user_id';

	/**
	 * Creates an array of DataExtension objects for sending Soap update to ExactTarget
	 * @param array $aUsersData Array of users data for update. Each should contain at least array of user id and email.
	 * @return array An array of DataExtension objects
	 * @throws \Wikia\Util\AssertionException
	 */
	public function prepareUsersUpdateParams( array $aUsersData ) {
		$aDataExtension = [ ];
		foreach ( $aUsersData as $aUserData ) {
			$userId = $this->extractUserIdFromData( $aUserData );
			Assert::true( !empty( $userId ) );

			$oDE = new \ExactTarget_DataExtensionObject();
			$oDE->CustomerKey = self::CUSTOMER_KEY_USER;
			$oDE->Keys = [ $this->wrapApiProperty( self::EXACT_TARGET_USER_ID_PROPERTY, $userId ) ];

			$aApiProperties = [ ];
			foreach ( $aUserData as $sKey => $sValue ) {
				$aApiProperties[ ] = $this->wrapApiProperty( $sKey, $sValue );
			}
			$oDE->Properties = $aApiProperties;

			$aDataExtension[ ] = $oDE;
		}
print_r($aDataExtension);
		return $aDataExtension;
	}

	/**
	 * Returns user_id element from $aUserData array and removes it from array
	 * This for API params preparation. Allows to use user_id separately as key
	 * and user data as update parameters without user_id
	 * @param array $aUserData key value data from user table
	 * @return int
	 */
	private function extractUserIdFromData( &$aUserData ) {
		$iUserId = $aUserData[ self::EXACT_TARGET_USER_ID_PROPERTY ];
		unset( $aUserData[ self::EXACT_TARGET_USER_ID_PROPERTY ] );
		return $iUserId;
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
