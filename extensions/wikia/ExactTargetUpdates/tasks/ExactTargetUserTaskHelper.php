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
				'ObjectType' => "DataExtensionObject[{$aCustomerKeys['user']}]",
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
		$sCustomerKey = $aCustomerKeys['user'];

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
		$sCustomerKey = $aCustomerKeys['user'];

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
			$aApiParams['DataExtension'][] = [
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
			$aApiParams['DataExtension'][] = [
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
	 * Prepares array of params for ExactTarget API for retrieving UserID_WikiID DataExtension objects
	 * @param array $aUsersIds Array consists of user ids in key. Value doesn't matter.
	 * e.g. $aUsersIds = [ 321, 12345 ]
	 * @return array
	 */
	public function prepareUserEditsRetrieveParams( array $aUsersIds ) {
		/* Get Customer Keys specific for production or development */
		$aCustomerKeys = $this->getCustomerKeys();
		$sCustomerKey = $aCustomerKeys['UserID_WikiID'];
		$aApiParams = [ 'DataExtension' => [] ];

		$aApiParams['DataExtension'] = [
			'ObjectType' => "DataExtensionObject[$sCustomerKey]",
			'Properties' => [ 'user_id', 'wiki_id', 'contributions' ],
		];

		$sSimpleOperator = 'equals';
		if ( count( $aUsersIds ) > 1 ) {
			$sSimpleOperator = 'IN';
		}

		$aApiParams['SimpleFilterPart'] = [
			'SimpleOperator' => $sSimpleOperator,
			'Property' => 'user_id',
			'Value' => $aUsersIds
		];
		return $aApiParams;
	}

	/**
	 * Prepares array of params for ExactTarget API for updating DataExtension objects for UserID_WikiID mapping
	 * @param int $iUserId User id
	 * @param array $aUsersEdits array of user ids and number of contributions on wikis
	 * e.g. $aUsersEdits = [ 12345 => [ 177 => 5 ] ]; It means user 12345 made 5 edits on 177 wiki
	 * @return array
	 */
	public function prepareUserEditsUpdateParams( array $aUsersEdits ) {
		/* Get Customer Keys specific for production or development */
		$aCustomerKeys = $this->getCustomerKeys();
		$sCustomerKey = $aCustomerKeys['UserID_WikiID'];
		$aApiParams = [ 'DataExtension' => [] ];
		foreach ( $aUsersEdits as $iUserId => $aWikiContributions ) {
			foreach ( $aWikiContributions as $iWikiId => $iContributions ) {
				$aApiParams['DataExtension'][] = [
					'CustomerKey' => $sCustomerKey,
					'Properties' => [ 'contributions' => $iContributions ],
					'Keys' => [
						'user_id' => $iUserId,
						'wiki_id' => $iWikiId
					]
				];
			}
		}
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
		$sCustomerKey = $aCustomerKeys['user_properties'];

		$aApiParams = [ 'DataExtension' => [] ];
		foreach ( $aUserProperties as $sProperty => $sValue ) {
			$aApiParams['DataExtension'][] = [
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
			$aApiParams['DataExtension'][] = [
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
		$iUserId = $aUserData['user_id'];
		unset( $aUserData['user_id'] );
		return $iUserId;
	}

	/**
	 * Returns User object for provided user ID
	 * @param int $iUserId
	 * @return \User
	 */
	public function getUserFromId( $iUserId ) {
		return \User::newFromId( $iUserId );
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
	 * Foreach record retrieved from ExactTarget add number of contributions to UsersEditsData for update
	 * requires parameters to have following structure
	 * [ 1234 => [ 177 => 5500 ] ] That means user with id 1234 made 5500 edits on wiki with 177 id
	 * @param array $aUsersEditsData
	 * @param array $aUserEditsDataFromET
	 */
	public function mergeUsersEditsData( array &$aUsersEditsData, array $aUserEditsDataFromET ) {
		foreach ( $aUserEditsDataFromET as $iUserId => $aWikiContributions ) {
			foreach ( $aWikiContributions as $iWikiId => $iContributions ) {
				if ( isset( $aUsersEditsData[$iUserId][$iWikiId] ) ) {
					$aUsersEditsData[$iUserId][$iWikiId] += $iContributions;
				}
			}
		}
	}

}
