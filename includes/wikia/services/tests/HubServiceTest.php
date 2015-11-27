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
			'actual corporate hompage — e.g. www.wikia.com (on 2015-11-26)' =>
				[ true, false, false, WikiFactoryHub::VERTICAL_ID_LIFESTYLE, 'fandom' ],
			'actual corporate hompage — e.g. pl.wikia.com' =>
				[ true, false, false, WikiFactoryHub::VERTICAL_ID_OTHER, 'fandom' ],

			// hypothetical cases
			'actual cororate hompage — hypothetical case, vertical: books' =>
				[ true, true, true, WikiFactoryHub::VERTICAL_ID_BOOKS, 'fandom' ],
			'actual cororate hompage — hypothetical case, vertical: comics' =>
				[ true, false, true, WikiFactoryHub::VERTICAL_ID_COMICS, 'fandom' ],
			'actual cororate hompage — hypothetical case, vertical: movies' =>
				[ true, true, false, WikiFactoryHub::VERTICAL_ID_MOVIES, 'fandom' ],

			// hub-based corporate homepages
			'hub-based corporate homepage — e.g. pt-br.wikia.com' =>
				[ false, true, true, WikiFactoryHub::VERTICAL_ID_OTHER, 'fandom' ],

			// hub-based corporate homepages — hypothetical case
			'hub-based corporate homepage — hypothetical case' =>
				[ false, true, true, WikiFactoryHub::VERTICAL_ID_LIFESTYLE, 'fandom' ],

			// corporate hubs
			'corporate hub — e.g. gryhub.wikia.com' =>
				[ false, true, false, WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES, 'gaming' ],
			'corporate hub — e.g. lifestylehub.wikia.com' =>
				[ false, true, false, WikiFactoryHub::VERTICAL_ID_LIFESTYLE, 'lifestyle' ],
			'corporate hub — e.g. tvhub.wikia.com' =>
				[ false, true, false, WikiFactoryHub::VERTICAL_ID_TV, 'entertainment' ],

			// corporate hubs — hypothetical case
			'corporate hub — hypothetical case' =>
				[ false, true, false, WikiFactoryHub::VERTICAL_ID_OTHER, 'lifestyle' ],

			// usual wiki(a)s
			'usual wiki(a) — vertical: games' =>
				[ false, false, false, WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES, 'gaming' ],
			'usual wiki(a) — vertical: lifestyle' =>
				[ false, false, false, WikiFactoryHub::VERTICAL_ID_LIFESTYLE, 'lifestyle' ],
			'usual wiki(a) — vertical: other' =>
				[ false, false, false, WikiFactoryHub::VERTICAL_ID_OTHER, 'lifestyle' ],
			'usual wiki(a) — vertical: music' =>
				[ false, false, false, WikiFactoryHub::VERTICAL_ID_MUSIC, 'entertainment' ],

			// usual wiki(a)s — hypothetical cases
			'usual wiki(a) — hypothetical case, vertical: games' =>
				[ false, false, true, WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES, 'gaming' ],
			'usual wiki(a) — hypothetical case, vertical: lifestyle' =>
				[ false, false, true, WikiFactoryHub::VERTICAL_ID_LIFESTYLE, 'lifestyle' ],
			'usual wiki(a) — hypothetical case, vertical: other' =>
				[ false, false, true, WikiFactoryHub::VERTICAL_ID_OTHER, 'lifestyle' ],
			'usual wiki(a) — hypothetical case, vertical: music' =>
				[ false, false, true, WikiFactoryHub::VERTICAL_ID_MUSIC, 'entertainment' ],
		];
	}
}
