<?php


class ExactTargetApiHelperTest extends WikiaBaseTest {

	const TEST_EMAIL = 'test@wikia-inc.com';
	const TEST_KEY = 'abc123';


	private $operators = array();
	private $helper;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();

		$this->helper = new \Wikia\ExactTarget\ExactTargetApiHelper();

		// we have to do this because the "auto" loaded ExactTarget_* classes
		// are not loaded properly within PHPUnit providers
		$this->operators['EQUALS'] = ExactTarget_SimpleOperators::equals;
		$this->operators['IN'] = ExactTarget_SimpleOperators::IN;
	}

	public function testWrapRetrieveRequest() {
		$type = 'sometype';
		$properties = [ 'a' => 1 ];
		$request = $this->helper->wrapRetrieveRequest( [
			'ObjectType' => $type,
			'Properties' => $properties,
			]);
		$this->assertNotNull( $request );
		$this->assertEquals( $properties, $request->Properties );
		$this->assertEquals( $type, $request->ObjectType );
	}

	public function testWrapCreateRequest() {
		$soapVars = [ 'something' => 1 ];
		$request = $this->helper->wrapCreateRequest( $soapVars );
		$this->assertNull( $request->Options );
		$this->assertEquals( $request->Objects, $soapVars );
	}

	/**
	 * @dataProvider simpleFilterPartProvider
	 */
	public function testWrapSimpleFilterPart($input, $expectedOperator) {
		$filter = $this->helper->wrapSimpleFilterPart( $input );

		$this->assertEquals( $input[ 'Value' ], $filter->Value );
		$this->assertEquals( $input[ 'Property' ], $filter->Property );
		$this->assertEquals( $this->operators[$expectedOperator], $filter->SimpleOperator );
	}

	public function simpleFilterPartProvider() {
		return [
			[ [ 'Value' => 'some-value', 'Property' => 'some-property' ], 'EQUALS' ],
			[ [ 'Value' => 'xyz', 'Property' => 'abc', 'SimpleOperator' =>	'IN' ], 'IN' ],
			[ [ 'Value' => 'some-value', 'Property' => 'some-property', 'SimpleOperator' =>	'foo' ], 'dne' ],
			];
	}

}
