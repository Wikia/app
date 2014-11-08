<?php
namespace Wikia\ExactTarget;

class ExactTargetUserTaskHelper {

	/**
	 * Prepares array of params for ExactTarget API for retrieving DataExtension objects from user table
	 * @param array $aProperties list of fields to retrieve
	 * @param string $sFilterProperty name of field to filter
	 * @param array $aFilterValues possible values to filter
	 * @return array
	 */
	public function prepareUserRetrieveParams( $aProperties, $sFilterProperty, $aFilterValues ) {
		/* Get Customer Keys specific for production or development */
		$aCustomerKeys = $this->getCustomerKeys();

		$aApiParams = [
			'DataExtension' => [
				'ObjectType' => "DataExtensionObject[{$aCustomerKeys[ 'user' ]}]",
				'Properties' => $aProperties,
			],
			'SimpleFilterPart' => [
				'Property' => $sFilterProperty,
				'Value' => $aFilterValues
			]
		];

		return $aApiParams;
	}

	/**
	 * Prepares array of params for ExactTarget API for creating DataExtension objects for user table
	 * Assumes $aUserData has user_id key that will be treated as filter to update data
	 * @param  array $aUserData  User key value array
	 * @return array             Array of DataExtension data arrays (nested arrays)
	 */
	public function prepareUserUpdateParams( array $aUserData ) {
		$userId = $this->extractUserIdFromData( $aUserData );
		/* Get Customer Keys specific for production or development */
		$aCustomerKeys = $this->getCustomerKeys();
		$sCustomerKey = $aCustomerKeys[ 'user' ];

		$aApiParams = [
			'DataExtension' => [
				[
					'CustomerKey' => $sCustomerKey,
					'Properties' => $aUserData,
					'Keys' => [ 'user_id' => $userId ]
				]
			]
		];
		return $aApiParams;
	}

	/**
	 * Prepares data for a user record removal
	 * @param  int $iUserId  User's ID
	 * @return array         Array of DataExtension data arrays (nested arrays)
	 */
	public function prepareUserDeleteParams( $iUserId ) {
		/* Get Customer Keys specific for production or development */
		$aCustomerKeys = $this->getCustomerKeys();
		$sCustomerKey = $aCustomerKeys[ 'user' ];

		$aApiParams = [
			'DataExtension' => [
				[
					'CustomerKey' => $sCustomerKey,
					'Keys' => [
						'user_id' => $iUserId
					]
				]
			]
		];

		return $aApiParams;
	}

	/**
	 * Prepares array of params for ExactTarget API for creating DataExtension objects for user_groups table
	 * @param  in $iUserId  User ID
	 * @param  array $aGroup   Array of strings (groups names)
	 * @return array           Array of DataExtension data arrays (nested arrays)
	 */
	public function prepareUserGroupCreateParams( $iUserId, array $aGroup ) {
		$aCustomerKeys = $this->getCustomerKeys();
		$aApiParams = [ 'DataExtension' => [] ];
		foreach ( $aGroup as $sGroup ) {
			$aApiParams[ 'DataExtension' ][] = [
				'CustomerKey' => $aCustomerKeys['user_groups'],
				'Properties' => [
					'ug_user' => $iUserId,
					'ug_group' => $sGroup
				]
			];
		}

		return $aApiParams;
	}

	/**
	 * Prepares array of params for ExactTarget API for removing DataExtension objects for user_groups table
	 * @param  int $iUserId    User ID
	 * @param  array $aGroup   Array of strings (groups names)
	 * @return array           Array of DataExtension data arrays (nested arrays)
	 */
	public function prepareUserGroupRemoveParams( $iUserId, array $aGroup ) {
		$aCustomerKeys = $this->getCustomerKeys();
		$aApiParams = [ 'DataExtension' => [] ];
		foreach ( $aGroup as $sGroup ) {
			$aApiParams[ 'DataExtension' ][] = [
				'CustomerKey' => $aCustomerKeys['user_groups'],
				'Keys' => [
					'ug_user' => $iUserId,
					'ug_group' => $sGroup
				]
			];
		}

		return $aApiParams;
	}

	/**
	 * Prepares Subscriber's object data
	 * @param  string $sUserEmail  User's email
	 * @return array               Array of Subscriber data arrays (nested arrays)
	 */
	public function prepareSubscriberData( $sUserEmail ) {
		$aApiParams = [
			'Subscriber' => [
				[
					'SubscriberKey' => $sUserEmail,
					'EmailAddress' => $sUserEmail,
				],
			],
		];

		return $aApiParams;
	}

	/**
	 * Prepares Subscriber's object data for delete
	 * @param  string $sUserEmail  User's email
	 * @return array               Array of Subscriber data arrays (nested arrays)
	 */
	public function prepareSubscriberDeleteData( $sUserEmail ) {
		$aApiParams = [
			'Subscriber' => [
				[
					'SubscriberKey' => $sUserEmail,
				],
			],
		];

		return $aApiParams;
	}

	/**
	 * Prepares array of params for ExactTarget API for creating DataExtension objects for user table
	 * @param int $iUserId User id
	 * @param array $aUserProperties user_properties key value array
	 * @return array
	 */
	public function prepareUserPropertiesUpdateParams( $iUserId, array $aUserProperties ) {
		/* Get Customer Keys specific for production or development */
		$aCustomerKeys = $this->getCustomerKeys();
		$sCustomerKey = $aCustomerKeys[ 'user_properties' ];

		$aApiParams = [ 'DataExtension' => [] ];
		foreach ( $aUserProperties as $sProperty => $sValue ) {
			$aApiParams[ 'DataExtension' ][] = [
				'CustomerKey' => $sCustomerKey,
				'Properties' => [ 'up_value' => $sValue ],
				'Keys' => [
					'up_user' => $iUserId,
					'up_property' => $sProperty
				]
			];
		}
		return $aApiParams;
	}

	/**
	 * Prepares array of params for ExactTarget API for removing DataExtension objects for user_properties table
	 * @param int $iUserId id of user to be deleted
	 * @return array
	 */
	public function prepareUserPropertiesDeleteParams( $iUserId ) {
		/*
		 * @var array $aUserPropertiesNames list of user properties sent to ExactTarget
		 * (see ExactTargetUpdatesHooks::prepareUserPropertiesParams)
		 */
		$aUserProperties = [
			'marketingallowed',
			'unsubscribed',
			'language'
		];
		/* Get Customer Keys specific for production or development */
		$aCustomerKeys = $this->getCustomerKeys();
		$sCustomerKey = $aCustomerKeys['user_properties'];

		$aApiParams = [ 'DataExtension' => [] ];
		foreach ( $aUserProperties as $sProperty ) {
			$aApiParams[ 'DataExtension' ][] = [
				'CustomerKey' => $sCustomerKey,
				'Keys' => [
					'up_user' => $iUserId,
					'up_property' => $sProperty
				]
			];
		}
		return $aApiParams;
	}

	/**
	 * Returns user_id element from $aUserData array and removes it from array
	 * @param array $aUserData key value data from user table
	 * @return int
	 */
	public function extractUserIdFromData( &$aUserData ) {
		$iUserId = $aUserData[ 'user_id' ];
		unset( $aUserData[ 'user_id' ] );
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
			'user_groups' => 'user_groups'
		];
		return $aCustomerKeys;
	}
}
