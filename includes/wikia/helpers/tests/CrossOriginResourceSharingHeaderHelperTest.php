<?php
use Wikia\Search\Test\BaseTest;

class CrossOriginResourceSharingHeaderHelperTest extends BaseTest {

	public function testShouldProperlySetHeaders() {
		$dummyResponse = new WikiaResponse( "tmp" );

		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->setAllowOrigin( [ 'a', 'b', 'c' ] );
		$cors->setHeaders( $dummyResponse );
		$headers = $dummyResponse->getHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME );

		$this->assertEquals( $headers[0]['value'], 'a,b,c' );
	}

	public function testShouldProperlySetHeadersWhenEmptyAllowOrigin() {
		$dummyResponse = new WikiaResponse( "tmp" );

		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->setAllowOrigin( [ ] );
		$cors->setHeaders( $dummyResponse );
		$headers = $dummyResponse->getHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME );

		$this->assertEquals( $headers[0]['value'], '' );
	}

	public function testShouldProperlySetHeadersWithPreExistingValues() {
		$dummyResponse = new WikiaResponse( "tmp" );
		$dummyResponse->setHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME,
			"t,m,p" );

		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->setAllowOrigin( [ "a", "b", "t" ] );
		$cors->setHeaders( $dummyResponse );
		$headers = $dummyResponse->getHeader( CrossOriginResourceSharingHeaderHelper::ALLOW_ORIGIN_HEADER_NAME );

		$this->assertEquals( $headers[0]['value'], 'a,b,t,t,m,p' );
	}
}
