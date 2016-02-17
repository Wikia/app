<?php

class ExactTargetRetrieveRequestBuilderTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider retrieveUserDataProvider
	 */
	public function testBuildRequest( $properties, $filterProperty, $filterValues ) {
		// Prepare Expected
		$expected = $this->prepareRetrieveRequest( $properties, $filterProperty, $filterValues );
		$oRequest = \Wikia\ExactTarget\ExactTargetRequestBuilder::createRetrieve()
			->withProperties( $properties )
			->withFilterProperty( $filterProperty )
			->withFilterValues( $filterValues )
			->build();
		$this->assertEquals( $expected, $oRequest );
	}

	public function retrieveUserDataProvider() {
		return [
			[ [ 'user_email' ], 'user_id', [ 1 ] ],
			[ [ 'user_email' ], 'user_id', [ 1, 2 ] ]
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

		$expected = new ExactTarget_RetrieveRequest();
		$expected->Filter = $this->wrapToSoapVar( $filter, 'SimpleFilterPart' );
		$expected->ObjectType = 'DataExtensionObject[user]';
		$expected->Properties = $properties;
		return $expected;
	}

	private function wrapToSoapVar( $oObject, $objectType = 'DataExtensionObject' ) {
		return new \SoapVar( $oObject, SOAP_ENC_OBJECT, $objectType, 'http://exacttarget.com/wsdl/partnerAPI' );
	}
}
