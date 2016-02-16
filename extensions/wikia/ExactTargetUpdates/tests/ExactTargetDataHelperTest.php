<?php

class ExactTargetDataHelperTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider usersDataProvider
	 */
	public function testUserUpdatePreparation( $params, $expected ) {
		$dataHelper = new \Wikia\ExactTarget\ExactTargetDataHelper();
		$this->assertEquals( $this->prepareExpected( $expected ), $dataHelper->prepareUsersUpdateParams( $params ) );
	}

	public function usersDataProvider() {
		return [
			// Test empty array
			[
				[ ], [ ]
			],
			// Test single user
			[
				[ [ 'user_id' => 1 ] ],
				[ [ 'user_id' => 1, 'properties' => [ ] ] ]
			],
			// Test double user
			[
				[ [ 'user_id' => 1 ], [ 'user_id' => 2 ] ],
				[ [ 'user_id' => 1, 'properties' => [ ] ], [ 'user_id' => 2, 'properties' => [ ] ] ]
			],
			// Test properties
			[
				[ [ 'user_id' => 1, 'user_email' => 'test@wikia.com' ] ],
				[ [ 'user_id' => 1, 'properties' => [ 'user_email' => 'test@wikia.com' ] ] ]
			],
			// Test two properties
			[
				[ [ 'user_id' => 1, 'user_email' => 'test@wikia.com', 'prop2' => 'val2' ] ],
				[ [ 'user_id' => 1, 'properties' => [ 'user_email' => 'test@wikia.com', 'prop2' => 'val2' ] ] ]
			]
		];
	}

	private function prepareExpected( $params ) {
		return array_map( [ $this, 'prepareUser' ], $params );
	}

	private function prepareUser( $params ) {
		$userExtensionObject = new ExactTarget_DataExtensionObject();
		$userExtensionObject->CustomerKey = 'user';
		$propParam = new ExactTarget_APIProperty();
		$propParam->Name = 'user_id';
		$propParam->Value = $params[ 'user_id' ];
		$userExtensionObject->Keys = [
			$propParam
		];
		$userExtensionObject->Properties = $this->prepareProperties( $params[ 'properties' ] );
		return $userExtensionObject;
	}

	private function prepareProperties( $param ) {
		$result = [ ];
		foreach ( $param as $key => $value ) {
			$userExtensionObject = new ExactTarget_APIProperty();
			$userExtensionObject->Name = $key;
			$userExtensionObject->Value = $value;
			$result[] = $userExtensionObject;
		}
		return $result;
	}


}
