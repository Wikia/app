<?php

class ExactTargetRequestBuilderTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider buildRequestDataProvider
	 */
	public function testBuildRequest( $usersParams ) {
		// Prepare params
		$dataExtensions = array_map( [ $this, 'prepareDataExtension' ], $usersParams );

		// Prepare Expected
		$expected = $this->prepareExpected( $dataExtensions );

		$requestBuilder = new \Wikia\ExactTarget\ExactTargetRequestBuilder();
		$oRequest = $requestBuilder->wrapUpdateRequest(
			$requestBuilder->prepareSoapVars( $dataExtensions, 'DataExtensionObject' ),
			$requestBuilder->prepareUpdateCreateOptions()
		);

		$this->assertEquals( $expected, $oRequest );
	}

	public function buildRequestDataProvider() {
		return [
			[ [ [ 'user_id' => 0 ] ] ],
			[ [ [ 'user_id' => 1 ] ] ],
			[ [ [ 'user_id' => 1 ], [ 'user_id' => 2 ] ] ],
			[ [ [ 'user_id' => 1, 'properties' => [ 'user_email' => 'test@wikia.com' ] ] ] ]
		];
	}

	/**
	 * @return ExactTarget_DataExtensionObject
	 */
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

	/**
	 * @param $dataExtension
	 * @return ExactTarget_UpdateRequest
	 * @internal param $saveOption
	 */
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
