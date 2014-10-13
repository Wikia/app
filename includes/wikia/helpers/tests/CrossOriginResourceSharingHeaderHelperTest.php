<?php
use Wikia\Search\Test\BaseTest;

class CrossOriginResourceSharingHeaderHelperTest extends BaseTest {

	public function testShouldFindExistingHeaders() {
		$headers = [ 'a: 1', 'Access-Control-Allow-Origin: aabb' ];
		$header = CrossOriginResourceSharingHeaderHelper::findExistingHeader( $headers );

		$this->assertEquals( $header, $headers[1] );

		$headers = [ 'access-Control-allow-Origin: aabb' ];
		$header = CrossOriginResourceSharingHeaderHelper::findExistingHeader( $headers );

		$this->assertEquals( $header, $headers[0] );
	}

	public function testShouldParseHeader() {
		$header = 'access-Control-allow-Origin: aabb';
		$value = CrossOriginResourceSharingHeaderHelper::extractHeaderValue( $header );

		$this->assertEquals( $value, 'aabb' );
	}
}
