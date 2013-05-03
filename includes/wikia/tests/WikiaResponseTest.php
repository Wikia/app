<?php
/**
 * @ingroup mwabstract
 */
class WikiaResponseTest extends PHPUnit_Framework_TestCase {

	const TEST_HEADER_NAME = 'X-WikiaResponseTest';
	const TEST_HEADER_VALUE1 = 'TestValue1';
	const TEST_HEADER_VALUE2 = 'TestValue2';
	const TEST_VAL_NAME = 'testMsg';
	const TEST_VAL_VALUE = 'This is a test value!';

	protected $app = null;

	/**
	 * @var WikiaResponse
	 */
	protected $object = null;

	protected function setUp() {
		$this->app = F::app();
		$this->object = $this->getMock( 'WikiaResponse', array( 'sendHeader' ), array( 'html' ) );
	}

	protected function tearDown() {
		F::setInstance( 'App', $this->app );
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

		// there is one additional header to be send, content-type
		$headersNum = $replace ? 2 : $headersNum + 1;

		$this->object->expects( $this->exactly( $headersNum ))->method( 'sendHeader' );
		$this->object->sendHeaders();
	}

	/**
	 * By default we send content-type header, plus response code in this test
	 */
	public function testSettingResponseCode() {
		$this->object->expects( $this->exactly(2) )->method( 'sendHeader' );
		$this->object->setCode(200);
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
	public function testView( $format ) {
		$this->object->setFormat( $format );
		$this->object->getView()->setTemplatePath( dirname( __FILE__ ) . '/_fixtures/TestTemplate.php' );
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

	public function testViewDefaultRender() {
		$this->object->setView( (new WikiaView) );
		$this->object->setFormat( 'raw' );

		$output = $this->object->getView()->render( $this->object );

		$this->assertStringStartsWith( '<pre>', $output );
	}

}
