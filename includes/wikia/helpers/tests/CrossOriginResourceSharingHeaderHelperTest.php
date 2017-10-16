<?php
use Wikia\Search\Test\BaseTest;

class CrossOriginResourceSharingHeaderHelperTest extends BaseTest {

	public function tearDown() {
		parent::tearDown();

		unset( $_SERVER['HTTP_ORIGIN'] );
	}

	private function setupHttpOrigin( $origin ) {
		$_SERVER['HTTP_ORIGIN'] = $origin;
	}

	public function testShouldProperlySetOriginHeaders() {
		$dummyResponse = new WikiaResponse( "tmp" );
		$this->setupHttpOrigin( 'c' );

		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->allowWhitelistedOrigins( [ 'a', 'b', 'c' ] )->setHeaders( $dummyResponse );

		$headers = $dummyResponse->getHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME );

		$this->assertEquals( $headers[0]['value'], 'c' );
	}

	public function testShouldProperlySetMethodHeaders() {
		$dummyResponse = new WikiaResponse( "tmp" );

		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->setAllowMethod( [ 'a', 'b', 'c' ] )->setHeaders( $dummyResponse );

		$headers = $dummyResponse->getHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_METHOD_HEADER_NAME );

		$this->assertEquals( $headers[0]['value'], 'a,b,c' );
	}

	public function testShouldProperlySetHeadersWhenEmptyAllowOrigin() {
		$dummyResponse = new WikiaResponse( "tmp" );

		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->allowWhitelistedOrigins()->setHeaders( $dummyResponse );

		$headers = $dummyResponse->getHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME );

		$this->assertEquals( null, $headers );
	}

	public function testShouldReturnWildcardWhenAllOriginsAllowed() {
		$dummyResponse = new WikiaResponse( "tmp" );
		( new CrossOriginResourceSharingHeaderHelper() )->setAllowAllOrigins()->setHeaders( $dummyResponse );
		$this->setupHttpOrigin( 'example.com' );

		$headers = $dummyResponse->getHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME );

		$this->assertEquals( '*', $headers[0]['value'] );
	}

	public function testWildcardGetsPrecedence() {
		$dummyResponse = new WikiaResponse( "tmp" );
		( new CrossOriginResourceSharingHeaderHelper() )
				->allowWhitelistedOrigins( ['a', 'b'] )
				->setAllowAllOrigins()
				->setHeaders( $dummyResponse );
		$this->setupHttpOrigin( 'example.com' );

		$headers = $dummyResponse->getHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME );

		$this->assertEquals( '*', $headers[0]['value'] );
	}

	public function testShouldProperlySetHeadersWithPreExistingValues() {
		$dummyResponse = new WikiaResponse( "tmp" );
		$dummyResponse->setHeader(
			CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME,
			"t,m,p"
		);
		$this->setupHttpOrigin( 't' );

		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->allowWhitelistedOrigins( [ "a", "b", "t" ] )->setHeaders( $dummyResponse );

		$headers = $dummyResponse->getHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME );

		$this->assertEquals( $headers[0]['value'], 't' );
	}

	public function testShouldProperlySetAllowCredentialsHeaderToTrue() {
		$dummyResponse = new WikiaResponse( "tmp" );

		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->setAllowCredentials( true )->setHeaders( $dummyResponse );

		$headers = $dummyResponse->getHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_CREDENTIALS_HEADER_NAME );

		$this->assertEquals( $headers[0]['value'], 'true' );
	}

	public function testShouldProperlySetAllowCredentialsHeaderToFalse() {
		$dummyResponse = new WikiaResponse( "tmp" );

		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->setAllowCredentials( false )->setHeaders( $dummyResponse );

		$headers = $dummyResponse->getHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_CREDENTIALS_HEADER_NAME );

		$this->assertEquals( $headers[0]['value'], 'false' );

	}

	public function testShouldProperlyReadCORSConfigFromGlobal() {
		$dummyResponse = new WikiaResponse( "tmp" );
		$this->setupHttpOrigin( 'a' );
		$this->mockGlobalVariable( 'wgCORSAllowOrigin', ['a', 'b', 'c'] );

		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->allowWhitelistedOrigins()->setHeaders( $dummyResponse );

		$headers = $dummyResponse->getHeader(
			CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME
		);
		$this->assertEquals( $headers[0]['value'], 'a' );
	}
}
