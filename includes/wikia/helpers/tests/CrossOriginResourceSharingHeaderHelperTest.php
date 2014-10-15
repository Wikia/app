<?php
use Wikia\Search\Test\BaseTest;

class CrossOriginResourceSharingHeaderHelperTest extends BaseTest {

	public function testShouldProperlySetHeaders() {
		$dummyResponse = new WikiaResponse("tmp");

		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->setAllowOrigin(['a', 'b', 'c']);
		$cors->setHeaders($dummyResponse);
		$headers = $dummyResponse->getHeader(CrossOriginResourceSharingHeaderHelper::HEADER_NAME);

		$this->assertEquals($headers[0]['value'], 'a,b,c');
	}
}
