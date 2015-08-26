<?php

/**
 * Class AdEngine2HooksIntegrationTest
 *
 * @group Integration
 */
class AdEngine2HooksIntegrationTest extends WikiaBaseTest {
	const SHOWCASE_ADTEST_PAGE_LINK = 'http://showcase.adtest.wikia.com/wiki/Wikia_Ad_Testing';
	const ADTEST_PAGE_LINK = 'http://adtest.wikia.com/wiki/Wikia_Ad_Testing';
	const NO_INDEX_NO_FOLLOW = '<meta name="robots" content="noindex,nofollow" />';
	const HTTP_OK = 200;

	public function testRobotsAllowedOnRegularPage() {
		$response = \Http::get(
			self::ADTEST_PAGE_LINK,
			'default',
			[ 'noProxy' => true, 'returnInstance' => true ]
		);
		$this->assertEquals( self::HTTP_OK, $response->getStatus() );
		$this->assertNotContains( self::NO_INDEX_NO_FOLLOW, $response->getContent() );
	}

	public function testRobotsAllowedOnShowcasePage() {
		$response = \Http::get(
			self::SHOWCASE_ADTEST_PAGE_LINK,
			'default',
			[ 'noProxy' => true, 'returnInstance' => true ]
		);
		$this->assertEquals( self::HTTP_OK, $response->getStatus() );
		$this->assertContains( self::NO_INDEX_NO_FOLLOW, $response->getContent() );
	}
}
