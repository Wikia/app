
<?php
/**
 * @group mwabstract
 */
class WikiaResponseTest extends PHPUnit_Framework_TestCase {

	const TEST_HEADER_NAME = 'X-WikiaResponseTest';
	const TEST_HEADER_VALUE1 = 'TestValue1';
	const TEST_HEADER_VALUE2 = 'TestValue2';
	const TEST_VAL_NAME = 'testMsg';
	const TEST_VAL_VALUE = 'This is a test value!';

	/**
	 * @var WikiaResponse
	 */
	protected $object = null;

	protected function setUp() {
		$this->object = $this->getMock( 'WikiaResponse', array( 'sendHeader' ), array( 'html' ) );
	}

	public function settingHeadersDataProvider() {
		return array(
			array(
				true,
				array(
					self::TEST_HEADER_VALUE1,
					self::TEST_HEADER_VALUE2
				)
			),
			array(
				false,
				array(
					self::TEST_HEADER_VALUE1,
					self::TEST_HEADER_VALUE2
				)
			)
		);
	}

	/**
	 *
	 * @dataProvider settingHeadersDataProvider
	 */
	public function testOperatingOnHeaders( $replace, $headerValues ) {
		$headersNum = count( $headerValues );
		foreach( $headerValues as $value ) {
			$this->object->setHeader( self::TEST_HEADER_NAME, $value, $replace );
		}

		$header = $this->object->getHeader( self::TEST_HEADER_NAME );

		if( $replace ) {
			$this->assertEquals( 1, count( $this->object->getHeaders() ) );
			$this->assertEquals( 1, count( $header ) );
			$this->assertEquals( self::TEST_HEADER_VALUE2, $header[0]['value'] );
		}
		else {
			$this->assertEquals( $headersNum, count( $this->object->getHeaders() ) );
			$this->assertEquals( $headersNum, count( $header ) );
			$i = 0;
			foreach( $headerValues as $value ) {
				$this->assertEquals( $value, $header[$i]['value'] );
				$i++;
			}
		}

		$this->object->expects( $replace ? $this->once() : $this->exactly( $headersNum ))->method( 'sendHeader' );
		$this->object->sendHeaders();
	}

	public function testSettingResponseCode() {
		$this->object->expects( $this->once() )->method( 'sendHeader' );
		$this->object->sendHeaders();
	}

	public function testOperatingOnData() {
		$val1 = array( 'key' => 'foo', 'val' => 1 );
		$val2 = array( 'key' => 'bar', 'val' => array( 1,2,3 ) );

		$this->object->setVal( $val1['key'], $val1['val'] );
		$this->object->setVal( $val2['key'], $val2['val'] );

		$this->assertEquals( 2, count( $this->object->getData() ) );
		$this->assertEquals( $val1['val'], $this->object->getVal( $val1['key'] ) );
		$this->assertEquals( $val2['val'], $this->object->getVal( $val2['key'] ) );
		$this->assertEquals( 'HelloWorld', $this->object->getVal( 'nonExistentVal', 'HelloWorld' ) );

		$this->object->setData( array() );
		$this->assertEmpty( $this->object->getData() );
	}

	public function testPrintingBody() {
		$this->object->setBody( 'Hello' );
		$this->object->appendBody( 'World' );

		$this->assertEquals( 'HelloWorld', $this->object->getBody() );

		ob_start();
		print $this->object;
		$buffer = ob_get_contents();
		ob_end_clean();

		$this->assertEquals( 'HelloWorld', $buffer );

		ob_start();
		$this->object->printText();
		$buffer = ob_get_contents();
		ob_end_clean();

		$this->assertEquals( 'HelloWorld', $buffer );
	}

	public function formatDataProvider() {
		return array(
		 array( 'html' ),
		 array( 'json' )
		);
	}

	/**
	 *
	 * @dataProvider formatDataProvider
	 */
	public function testPrinters( $format ) {
		$this->object->setFormat( $format );
		$this->object->setTemplatePath( dirname( __FILE__ ) . '/_fixtures/TestTemplate.php' );
		$this->object->setVal( self::TEST_VAL_NAME, self::TEST_VAL_VALUE );
		if( $format == 'json' ) {
			$this->object->setException( new WikiaException('TestException') );
		}

		$this->object->sendHeaders();

		ob_start();
		print $this->object;
		$buffer = ob_get_contents();
		ob_end_clean();

		if( $format == 'html' ) {
			$this->assertEquals( self::TEST_VAL_VALUE, $buffer );
		}
	}

	public function testDefaultPrinter() {
		$this->object->setPrinter( F::build( 'WikiaResponsePrinter' ) );
		$output = $this->object->getPrinter()->render( $this->object );

		$this->assertStringStartsWith( '<pre>', $output );
	}

	public function buildingTemplatePathDataProvider() {
		return array(
		 array( true ),
		 array( false )
		);
	}

	/**
	 * @dataProvider buildingTemplatePathDataProvider
	 */
	public function testBuildingTemplatePath( $classExists ) {
		$app = F::build( 'App' );

		$appMock = $this->getMock( 'WikiaApp', array( 'getGlobal' ) );
		$appMock->expects( $this->once() )
		        ->method( 'getGlobal' )
		        ->with( $this->equalTo( 'wgAutoloadClasses' ) )
		        ->will( $classExists ? $this->returnValue( array( __CLASS__ . 'Controller' => __FILE__ ) ) : $this->returnValue( array() ) );

		F::setInstance( 'App', $appMock );

		if( !$classExists ) {
			$this->setExpectedException( 'WikiaException' );
		}
		$this->object->buildTemplatePath( __CLASS__, 'hello', true );

		if( $classExists ) {
			$this->assertEquals( (dirname( __FILE__ ) . '/templates/' . __CLASS__ . '_hello.php'), $this->object->getTemplatePath() );
		}

		F::setInstance( 'App', $app );
	}

}