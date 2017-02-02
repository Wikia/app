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

		// there are two additional headers to be sent, content-type and vary
		$headersNum = $replace ? 3 : $headersNum + 2;

		$this->object->expects( $this->exactly( $headersNum ))->method( 'sendHeader' );
		$this->object->sendHeaders();
	}

	/**
	 * By default we send content-type and vary headers, plus response code in this test
	 */
	public function testSettingResponseCode() {
		$this->object->expects( $this->exactly( 3 ) )->method( 'sendHeader' );
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
		$this->object->setFormat( 'json' );

		$output = $this->object->getView()->render( $this->object );

		$this->assertStringStartsWith( '[]', $output );
	}

	/**
	 * @dataProvider cachingHeadersProvider
	 */
	public function testCachingHeaders($varnishTTL, $clientTTL, $cachingPolicy, $expectedValue, $passExpectedValue) {
		$this->object->setCachePolicy($cachingPolicy);
		$this->object->setCacheValidity( $varnishTTL, $clientTTL );

		$cacheControlValue = $this->object->getHeader( 'Cache-Control' )[0]['value'];
		$passCacheControlValue = $this->object->getHeader( 'X-Pass-Cache-Control' )[0]['value'];

		$this->assertEquals( $expectedValue, $cacheControlValue, 'Cache-Control header should match the expected value' );
		$this->assertEquals( $passExpectedValue, $passCacheControlValue, 'X-Pass-Cache-Control header should match the expected value' );
	}

	public function cachingHeadersProvider() {
		return [
			// no caching, but Varnish would still cache it for 5 seconds
			[
				WikiaResponse::CACHE_DISABLED, false,
				WikiaResponse::CACHE_PUBLIC,
				's-maxage=5', null
			],
			// cache on Varnish only
			[
				60, WikiaResponse::CACHE_DISABLED,
				WikiaResponse::CACHE_PUBLIC,
				's-maxage=60', null
			],
			// cache on both
			[
				60, false,
				WikiaResponse::CACHE_PUBLIC,
				's-maxage=60', 'public, max-age=60'
			],
			// cache on both (different TTLs)
			[
				WikiaResponse::CACHE_STANDARD, 60,
				WikiaResponse::CACHE_PUBLIC,
				's-maxage=86400', 'public, max-age=60'
			],
			// Varnish caching disabled, private caching
			[
				WikiaResponse::CACHE_DISABLED, false,
				WikiaResponse::CACHE_PRIVATE,
				'private, s-maxage=0', null
			],
			// only private caching
			[
				WikiaResponse::CACHE_DISABLED, WikiaResponse::CACHE_STANDARD,
				WikiaResponse::CACHE_PRIVATE,
				'private, s-maxage=0', 'private, max-age=86400'
			],
		];
	}
}
