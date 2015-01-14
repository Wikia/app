<?php
use Wikia\Search\Test\BaseTest;

class CrossOriginResourceSharingHeaderHelperTest extends BaseTest {

	public function testShouldProperlySetOriginHeaders() {
		$dummyResponse = new WikiaResponse( "tmp" );

		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->setAllowOrigin( [ 'a', 'b', 'c' ] )->setHeaders( $dummyResponse );

		$headers = $dummyResponse->getHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME );

		$this->assertEquals( $headers[0]['value'], 'a,b,c' );
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
		$cors->setAllowOrigin( [ ] )->setHeaders( $dummyResponse );

		$headers = $dummyResponse->getHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME );

		$this->assertEquals( $headers[0]['value'], '' );
	}

	public function testShouldProperlySetHeadersWithPreExistingValues() {
		$dummyResponse = new WikiaResponse( "tmp" );
		$dummyResponse->setHeader(
			CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME,
			"t,m,p"
		);

		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->setAllowOrigin( [ "a", "b", "t" ] )->setHeaders( $dummyResponse );

		$headers = $dummyResponse->getHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME );

		$this->assertEquals( $headers[0]['value'], 'a,b,t,t,m,p' );
	}

	public function testShouldProperlyReadCORSConfigFromGlobal()
	{
		global $wgCORSAllowOrigin;
		$wgCORSAllowOrigin = [ "a", "b", "c" ];
		$dummyResponse = new WikiaResponse( "tmp" );

		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->readConfig()->setHeaders( $dummyResponse );

		$headers = $dummyResponse->getHeader(
			CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME
		);
		$this->assertEquals( $headers[0]['value'], 'a,b,c' );
	}
}
