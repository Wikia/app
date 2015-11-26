<?php

class HubServiceTest extends WikiaBaseTest {

	/**
	 * @dataProvider getVerticalNameForComscoreDataProvider
	 * @param boolean $wgDisableWAMOnHubsMock
	 * @param boolean $isWikiaHomePageValueMock
	 * @param boolean $isWikiaHubValueMock
	 * @param integer $verticalIdMock
	 * @param string $expectedVerticalName
	 */
	public function testGetVerticalNameForComscore(
		$isWikiaHomePageValueMock,
		$isWikiaHubValueMock,
		$wgDisableWAMOnHubsMock,
		$verticalIdMock,
		$expectedVerticalName
	) {
		$this->mockGlobalVariable( 'wgDisableWAMOnHubs', $wgDisableWAMOnHubsMock );

		$this->mockStaticMethod( 'WikiaPageType', 'isWikiaHomePage', $isWikiaHomePageValueMock );
		$this->mockStaticMethod( 'WikiaPageType', 'isWikiaHub', $isWikiaHubValueMock );

		$wikiFactoryHubMock = $this->getMock( 'WikiFactoryHub', [ 'getVerticalId' ] );

		$this->mockStaticMethod( 'WikiFactoryHub', 'getInstance', $wikiFactoryHubMock );

		$wikiFactoryHubMock->expects( $this->any() )
			->method( 'getVerticalId' )
			->will( $this->returnValue( $verticalIdMock ) );

		$this->assertEquals( $expectedVerticalName, HubService::getVerticalNameForComscore( 1 ) );
	}

	public function getVerticalNameForComscoreDataProvider() {
		return [
			// actual corporate hompages
			// e.g. www.wikia.com (on 2015-11-26)
			[ true, false, false, WikiFactoryHub::VERTICAL_ID_LIFESTYLE, 'fandom' ],
			// e.g. pl.wikia.com
			[ true, false, false, WikiFactoryHub::VERTICAL_ID_OTHER, 'fandom' ],
			// hypothetical cases
			[ true, true, true, WikiFactoryHub::VERTICAL_ID_BOOKS, 'fandom' ],
			[ true, false, true, WikiFactoryHub::VERTICAL_ID_COMICS, 'fandom' ],
			[ true, true, false, WikiFactoryHub::VERTICAL_ID_MOVIES, 'fandom' ],

			// hub-based corporate homepages
			// e.g. pt-br.wikia.com
			[ false, true, true, WikiFactoryHub::VERTICAL_ID_OTHER, 'fandom' ],
			// hypothetical case
			[ false, true, true, WikiFactoryHub::VERTICAL_ID_LIFESTYLE, 'fandom' ],

			// corporate hubs
			// e.g. gryhub.wikia.com
			[ false, true, false, WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES, 'gaming' ],
			// e.g. lifestylehub.wikia.com
			[ false, true, false, WikiFactoryHub::VERTICAL_ID_LIFESTYLE, 'lifestyle' ],
			// e.g. tvhub.wikia.com
			[ false, true, false, WikiFactoryHub::VERTICAL_ID_TV, 'entertainment' ],
			// hypothetical case
			[ false, true, false, WikiFactoryHub::VERTICAL_ID_OTHER, 'lifestyle' ],

			// usual wiki(a)s
			[ false, false, false, WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES, 'gaming' ],
			[ false, false, false, WikiFactoryHub::VERTICAL_ID_LIFESTYLE, 'lifestyle' ],
			[ false, false, false, WikiFactoryHub::VERTICAL_ID_OTHER, 'lifestyle' ],
			[ false, false, false, WikiFactoryHub::VERTICAL_ID_MUSIC, 'entertainment' ],

			// hypothetical cases
			[ false, false, true, WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES, 'gaming' ],
			[ false, false, true, WikiFactoryHub::VERTICAL_ID_LIFESTYLE, 'lifestyle' ],
			[ false, false, true, WikiFactoryHub::VERTICAL_ID_OTHER, 'lifestyle' ],
			[ false, false, true, WikiFactoryHub::VERTICAL_ID_MUSIC, 'entertainment' ],
		];
	}
}
