<?php

class HubServiceTest extends WikiaBaseTest {

	/**
	 * @dataProvider getVerticalNameForComscoreDataProvider
	 * @param (boolean|integer)[] $mocks
	 * @param string $expectedVerticalName
	 */
	public function testGetVerticalNameForComscore( $mocks, $expectedVerticalName ) {
		$this->mockGlobalVariable( 'wgDisableWAMOnHubs', $mocks['wgDisableWAMOnHubs'] );

		$this->mockStaticMethod( 'WikiaPageType', 'isWikiaHomePage', $mocks['isWikiaHomePage'] );
		$this->mockStaticMethod( 'WikiaPageType', 'isWikiaHub', $mocks['isWikiaHub'] );

		$wikiFactoryHubMock = $this->getMock( 'WikiFactoryHub', [ 'getVerticalId' ] );

		$this->mockStaticMethod( 'WikiFactoryHub', 'getInstance', $wikiFactoryHubMock );

		$wikiFactoryHubMock->expects( $this->any() )
			->method( 'getVerticalId' )
			->will( $this->returnValue( $mocks['verticalId'] ) );

		$this->assertEquals( $expectedVerticalName, HubService::getVerticalNameForComscore( 1 ) );
	}

	public function getVerticalNameForComscoreDataProvider() {
		return [
			//actual corporate homepages
			'actual corporate hompage — e.g. www.wikia.com (on 2015-11-26)' => [
				[
					'isWikiaHomePage' => true,
					'isWikiaHub' => false,
					'wgDisableWAMOnHubs' => false,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_LIFESTYLE
				],
				'fandom'
			],
			'actual corporate hompage — e.g. pl.wikia.com' => [
				[
					'isWikiaHomePage' => true,
					'isWikiaHub' => false,
					'wgDisableWAMOnHubs' => false,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_OTHER
				],
				'fandom'
			],
			// hypothetical cases
			'actual cororate hompage — hypothetical case, vertical: books' => [
				[
					'isWikiaHomePage' => true,
					'isWikiaHub' => true,
					'wgDisableWAMOnHubs' => true,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_BOOKS
				],
				'fandom'
			],
			'actual cororate hompage — hypothetical case, vertical: comics' => [
				[
					'isWikiaHomePage' => true,
					'isWikiaHub' => false,
					'wgDisableWAMOnHubs' => true,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_COMICS
				],
				'fandom'
			],
			'actual cororate hompage — hypothetical case, vertical: movies' => [
				[
					'isWikiaHomePage' => true,
					'isWikiaHub' => true,
					'wgDisableWAMOnHubs' => false,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_MOVIES
				],
				'fandom'
			],

			// hub-based corporate homepages
			'hub-based corporate homepage — e.g. pt-br.wikia.com' => [
				[
					'isWikiaHomePage' => false,
					'isWikiaHub' => true,
					'wgDisableWAMOnHubs' => true,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_OTHER
				],
				'fandom'
			],
			'hub-based corporate homepage — hypothetical case' => [
				[
					'isWikiaHomePage' => false,
					'isWikiaHub' => true,
					'wgDisableWAMOnHubs' => true,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_LIFESTYLE
				],
				'fandom'
			],

			// corporate hubs
			'corporate hub — e.g. gryhub.wikia.com' => [
				[
					'isWikiaHomePage' => false,
					'isWikiaHub' => true,
					'wgDisableWAMOnHubs' => false,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES
				],
				'gaming'
			],
			'corporate hub — e.g. lifestylehub.wikia.com' => [
				[
					'isWikiaHomePage' => false,
					'isWikiaHub' => true,
					'wgDisableWAMOnHubs' => false,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_LIFESTYLE
				],
				'lifestyle'
			],
			'corporate hub — e.g. tvhub.wikia.com' => [
				[
					'isWikiaHomePage' => false,
					'isWikiaHub' => true,
					'wgDisableWAMOnHubs' => false,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_TV
				],
				'entertainment'
			],
			// hypothetical case
			'corporate hub — hypothetical case' => [
				[
					'isWikiaHomePage' => false,
					'isWikiaHub' => true,
					'wgDisableWAMOnHubs' => false,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_OTHER
				],
				'lifestyle'
			],

			// usual wiki(a)s
			'usual wiki(a) — vertical: games' => [
				[
					'isWikiaHomePage' => false,
					'isWikiaHub' => false,
					'wgDisableWAMOnHubs' => false,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES
				],
				'gaming'
			],
			'usual wiki(a) — vertical: lifestyle ' => [
				[
					'isWikiaHomePage' => false,
					'isWikiaHub' => false,
					'wgDisableWAMOnHubs' => false,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_LIFESTYLE
				],
				'lifestyle'
			],
			'usual wiki(a) — vertical: other' => [
				[
					'isWikiaHomePage' => false,
					'isWikiaHub' => false,
					'wgDisableWAMOnHubs' => false,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_OTHER
				],
				'lifestyle'
			],
			'usual wiki(a) — vertical: music' => [
				[
					'isWikiaHomePage' => false,
					'isWikiaHub' => false,
					'wgDisableWAMOnHubs' => false,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_MUSIC
				],
				'entertainment'
			],
			// hypothetical cases
			'usual wiki(a) — hypothetical case, vertical: games' => [
				[
					'isWikiaHomePage' => false,
					'isWikiaHub' => false,
					'wgDisableWAMOnHubs' => true,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES
				],
				'gaming'
			],
			'usual wiki(a) — hypothetical case, vertical: lifestyle' => [
				[
					'isWikiaHomePage' => false,
					'isWikiaHub' => false,
					'wgDisableWAMOnHubs' => true,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_LIFESTYLE
				],
				'lifestyle'
			],
			'usual wiki(a) — hypothetical case, vertical: other' => [
				[
					'isWikiaHomePage' => false,
					'isWikiaHub' => false,
					'wgDisableWAMOnHubs' => true,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_OTHER
				],
				'lifestyle'
			],
			'usual wiki(a) — hypothetical case, vertical: music' => [
				[
					'isWikiaHomePage' => false,
					'isWikiaHub' => false,
					'wgDisableWAMOnHubs' => true,
					'verticalId' => WikiFactoryHub::VERTICAL_ID_MUSIC
				],
				'entertainment'
			],
		];
	}
}
