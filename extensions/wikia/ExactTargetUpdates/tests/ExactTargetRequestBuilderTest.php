<?php

class ExactTargetRequestBuilderTest extends WikiaBaseTest {
	public function setUp() {
		require_once __DIR__ . '/helpers/RequestBuilderTestsHelper.class.php';
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	public function testWrongTypeProvided() {
		$this->setExpectedException( 'Wikia\Util\AssertionException', 'Not supported request type' );
		new \Wikia\ExactTarget\Builders\DeleteRequestBuilder();
	}

	/**
	 * @dataProvider usersDataProvider
	 */
	public function testBuildRequest( $usersData, $expectedParams ) {
		// Prepare Expected
		$dataExtensions = array_map( [ $this, 'prepareDataExtension' ], $expectedParams );
		$expected = $this->prepareSaveOption( $dataExtensions );

		$oRequest = \Wikia\ExactTarget\ExactTargetRequestBuilder::getUpdateBuilder()
			->withUserData( $usersData )
			->build();

		$this->assertEquals( $expected, $oRequest );
	}

	public function testEmptyUser() {
		$this->setExpectedException( 'Wikia\Util\AssertionException' );
		\Wikia\ExactTarget\ExactTargetRequestBuilder::getUpdateBuilder()
			->withUserData( [ [ 'user_id' => 0 ] ] )
			->build();
	}

	/**
	 * @dataProvider userPreferencesProvider
	 */
	public function testUserPreferencesQueryBuild( $iUserId, $aUserProperties ) {
		$data = [ ];
		foreach ( $aUserProperties as $name => $value ) {
			$dataExtension = new ExactTarget_DataExtensionObject();
			$dataExtension->Keys = [
				RequestBuilderTestsHelper::prepareApiProperty( 'up_user', $iUserId ),
				RequestBuilderTestsHelper::prepareApiProperty( 'up_property', $name ),
			];
			$dataExtension->CustomerKey = 'user_properties';
			$dataExtension->Properties = [
				RequestBuilderTestsHelper::prepareApiProperty( 'up_value', $value )
			];
			$data[] = $dataExtension;
		}
		$expected = $this->prepareSaveOption( $data );

		$oRequest = \Wikia\ExactTarget\ExactTargetRequestBuilder::getUpdateBuilder()
			->withUserId( $iUserId )
			->withProperties( $aUserProperties )
			->build();

		$this->assertEquals( $expected, $oRequest );
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

	public function emailsDataProvider() {
		return [
			[ ],
			[ 'test@test.com' ],
		];
	}

	public function userPreferencesProvider() {
		return [
			[ 1, [ ] ],
			[ 1, [ 'test' => 1, 'test2' => 2 ] ],
			[ 1, null ],
		];
	}

	/** Tests helpers methods */

	private function prepareDataExtension( $userParams ) {
		$apiProperty = RequestBuilderTestsHelper::prepareApiProperty( 'user_id', $userParams[ 'user_id' ] );

		$dataExtension = new ExactTarget_DataExtensionObject();
		$dataExtension->Name = '';
		$dataExtension->Keys = [ $apiProperty ];
		$dataExtension->CustomerKey = 'user';
		$dataExtension->Properties = $this->prepareProperties( $userParams[ 'properties' ] );
		return $dataExtension;
	}

	private function prepareSaveOption( $dataExtensions ) {
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
			$result[] = $userExtensionObject;
		}
		return $result;
	}
}
