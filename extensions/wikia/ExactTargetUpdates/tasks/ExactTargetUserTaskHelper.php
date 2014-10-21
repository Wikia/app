<?php

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
		$sCustomerKey = $aCustomerKeys[ 'user' ];
		$aApiParams = [
			'DataExtension' => [
				'CustomerKey' => $sCustomerKey,
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
	 * @param array $aUserData user key value array
	 * @return array
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
	 * Prepares DataExtension params for prepareApiCreateParams method
	 * @param int $iUserId
	 * @param array $aUserProperties array of property name => value pairs
	 * @return array
	 */
	public function prepareUserPropertiesCreateParams( $iUserId, array $aUserProperties ) {
		$aDataExtensionsParams = [];
		foreach ( $aUserProperties as $sProperty => $sValue ) {
			$aDataExtensionsParams[] = [
				'up_user' => $iUserId,
				'up_property' => $sProperty,
				'up_value' => $sValue
			];
		}
		return $aDataExtensionsParams;
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
	 * Returns array of params for ExactTarget API for creating DataExtension objects
	 * @param array $aDataExtensionsParams
	 * @param string $sCustomerKey
	 * @return array
	 * e.g result params for creating two DataExtenision objects
	 * [
	 *   [
	 *     'DataExtension' => [
	 *       'CustomerKey' => 'user_properties',
	 *       'Properties' => ['key'='value']
	 *     ]
	 *   ]
	 *   [
	 *     'DataExtension' => [
	 *       'CustomerKey' => 'user_properties',
	 *       'Properties' => ['key'='value']
	 *     ]
	 *   ]
	 * ]
	 */
	public function prepareApiCreateParams( $aDataExtensionsParams, $sCustomerKey ) {
		$aApiParams = [];
		foreach ( $aDataExtensionsParams as $aProperties ) {
			$aApiParams[] = [
				'DataExtension' => [
					'CustomerKey' => $sCustomerKey,
					'Properties' => $aProperties
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
	 * Get Customer Keys specific for production or development
	 * CustomerKey is a key that indicates Wikia table reflected by DataExtension
	 */
	private function getCustomerKeys() {
		global $wgExactTargetDevelopmentMode;

		if ( $wgExactTargetDevelopmentMode ) {
			$aCustomerKeys = [
				'user' => 'user_dev',
				'user_properties' => 'user_properties_dev',
			];
		} else {
			$aCustomerKeys = [
				'user' => 'user',
				'user_properties' => 'user_properties',
			];
		}
		return $aCustomerKeys;
	}
}
