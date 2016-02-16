<?php

class ExactTargetRequestBuilderTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider usersDataProvider
	 */
	public function testBuildRequest( $usersData, $expectedParams ) {
		// Prepare Expected
		$dataExtensions = array_map( [ $this, 'prepareDataExtension' ], $expectedParams );
		$expected = $this->prepareExpected( $dataExtensions );

		$oRequest = \Wikia\ExactTarget\ExactTargetRequestBuilder::createUpdate()
			->withUserData( $usersData )
			->build();

		$this->assertEquals( $expected, $oRequest );
	}

	public function testEmptyUser() {
		$this->setExpectedException( 'Wikia\Util\AssertionException' );
		\Wikia\ExactTarget\ExactTargetRequestBuilder::createUpdate()
			->withUserData([ [ 'user_id' => 0 ] ])
			->build();
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

	/** Tests helpers methods */

	private function prepareDataExtension( $userParams ) {
		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = 'user_id';
		$apiProperty->Value = $userParams[ 'user_id' ];

		$dataExtension = new ExactTarget_DataExtensionObject();
		$dataExtension->Name = '';
		$dataExtension->Keys = [ $apiProperty ];
		$dataExtension->CustomerKey = 'user';
		$dataExtension->Properties = $this->prepareProperties( $userParams['properties'] );
		return $dataExtension;
	}

	private function prepareExpected( $dataExtensions ) {
		$saveOption = new \ExactTarget_SaveOption();
		$saveOption->PropertyName = 'DataExtensionObject';
		$saveOption->SaveAction = \ExactTarget_SaveAction::UpdateAdd;

		$options = new ExactTarget_UpdateOptions();
		$options->SaveOptions = [ $this->wrapToSoapVar( $saveOption, 'SaveOption' ) ];

		$expected = new ExactTarget_UpdateRequest();
		$expected->Options = $options;
		$expected->Objects = array_map( [ $this, 'wrapToSoapVar' ], $dataExtensions );
		return $expected;
	}

	private function wrapToSoapVar( $oObject, $objectType = 'DataExtensionObject' ) {
		return new \SoapVar( $oObject, SOAP_ENC_OBJECT, $objectType, 'http://exacttarget.com/wsdl/partnerAPI' );
	}

	private function prepareProperties( $param ) {
		$result = [ ];
		foreach ( $param as $key => $value ) {
			$userExtensionObject = new ExactTarget_APIProperty();
			$userExtensionObject->Name = $key;
			$userExtensionObject->Value = $value;
			$result[ ] = $userExtensionObject;
		}
		return $result;
	}
}
