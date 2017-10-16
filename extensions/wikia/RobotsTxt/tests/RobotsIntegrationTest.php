<?php

/**
 * Class RobotsIntegrationTest
 *
 * @group SeoIntegration
 */
class RobotsIntegrationTest extends WikiaBaseTest {
	const SHOWCASE_ADTEST_PAGE_LINK = 'http://showcase.adtest.wikia.com/wiki/Wikia_Ad_Testing';
	const ADTEST_PAGE_LINK = 'http://adtest.wikia.com/wiki/Wikia_Ad_Testing';
	const NO_INDEX_NO_FOLLOW = '<meta name="robots" content="noindex,nofollow" />';
	const NO_INDEX_FOLLOW = '<meta name="robots" content="noindex,follow" />';
	const HTTP_OK = 200;

	public function testRobotsAllowedOnRegularPage() {
		$response = $this->getHttpGerResponse( self::ADTEST_PAGE_LINK );
		$this->assertEquals( self::HTTP_OK, $response->getStatus() );
		$this->assertNotContains( self::NO_INDEX_NO_FOLLOW, $response->getContent() );
	}

	/**
	 * @dataProvider getSpecialPagesUrlsDataProvider
	 */
	public function testRobotsDeniedOnSpecialPages( $url, $expected ) {
		$response = \Http::get(
			$url,
			'default',
			[
				'noProxy' => true,
				'returnInstance' => true,
				'followRedirects' => true,
				'maxRedirects' => 10,
				'timeout' => 30
			]
		);
		$this->assertNotEmpty( $response->getStatus() );
		$this->assertContains( $expected, $response->getContent() );
	}

	public function getSpecialPagesUrlsDataProvider() {
		$urlPattern = 'http://adtest.wikia.com/wiki/%s';
		$cb = time();
		return [
			[ sprintf($urlPattern, 'Skin?action=edit&cb=' . $cb), self::NO_INDEX_NO_FOLLOW ],
			[ sprintf($urlPattern, 'Special:RecentChanges?cb=' . $cb), self::NO_INDEX_NO_FOLLOW ],
			[ sprintf($urlPattern, 'Special:SpecialPages?cb=' . $cb), self::NO_INDEX_NO_FOLLOW ],
			[ sprintf($urlPattern, 'Special:BrokenRedirects?cb=' . $cb), self::NO_INDEX_NO_FOLLOW ],
			[ sprintf($urlPattern, 'Special:ProtectedPages?cb=' . $cb), self::NO_INDEX_NO_FOLLOW ],
			[ sprintf($urlPattern, 'Special:AllPages?cb=' . $cb), self::NO_INDEX_NO_FOLLOW ],
			[ sprintf($urlPattern, 'Special:Contact?cb=' . $cb), self::NO_INDEX_NO_FOLLOW ],
			[ 'http://www.wikia.com/Sitemap?cb=' . $cb, static::NO_INDEX_FOLLOW ]
		];
	}

	public function testRobotsDeniedOnShowcasePage() {
		$response = $this->getHttpGerResponse( self::SHOWCASE_ADTEST_PAGE_LINK );
		$this->assertEquals( self::HTTP_OK, $response->getStatus() );
		$this->assertContains( self::NO_INDEX_NO_FOLLOW, $response->getContent() );
	}

	private function getHttpGerResponse( $url ) {
		return \Http::get(
			$url,
			'default',
			[ 'noProxy' => true, 'returnInstance' => true ]
		);
	}

}
