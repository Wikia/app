<?php

class ExactTargetRetrieveRequestBuilderTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../../../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider retrieveUserDataProvider
	 */
	public function testBuildRequest( $properties, $filterProperty, $filterValues, $resource ) {
		// Prepare Expected
		$expected = $this->prepareRetrieveRequest( $properties, $filterProperty, $filterValues );
		$oRequest = \Wikia\ExactTarget\ExactTargetRequestBuilder::getRetrieveBuilder()
			->withProperties( $properties )
			->withFilterProperty( $filterProperty )
			->withFilterValues( $filterValues )
			->withResource( $resource )
			->build();
		$this->assertEquals( $expected, $oRequest );
	}

	public function retrieveUserDataProvider() {
		return [
			[ [ 'user_email' ], 'user_id', [ 1 ], 'user' ],
			[ [ 'user_email' ], 'user_id', [ 1, 2 ], 'user' ],
		];
	}

	private function prepareRetrieveRequest( $properties, $filterProperty, $filterValues ) {
		$filter = new \ExactTarget_SimpleFilterPart();
		$filter->Property = $filterProperty;
		$filter->SimpleOperator = 'equals';
		if ( count( $filterValues ) > 1 ) {
			$filter->SimpleOperator = 'IN';
		}
		$filter->Value = $filterValues;

		$expectedPart = new ExactTarget_RetrieveRequest();
		$expectedPart->Filter = $this->wrapToSoapVar( $filter, 'SimpleFilterPart' );
		$expectedPart->ObjectType = 'DataExtensionObject[user]';
		$expectedPart->Properties = $properties;

		$expected = new \ExactTarget_RetrieveRequestMsg();
		$expected->RetrieveRequest = $expectedPart;
		return $expected;
	}

	private function wrapToSoapVar( $oObject, $objectType = 'DataExtensionObject' ) {
		return new \SoapVar( $oObject, SOAP_ENC_OBJECT, $objectType, 'http://exacttarget.com/wsdl/partnerAPI' );
	}
}
