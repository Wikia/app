<?php

class DesignSystemGlobalFooterModelTest extends WikiaBaseTest {
	/**
	 * @dataProvider licensingAndVerticalProvider
	 */
	public function testLicensingAndVerticalData( $rightsText, $rightsUrl, $vertical, $expectedResult ) {
		$wikiId = 1234;

		$wfHubMock = $this->getMock( 'WikiFactoryHub', [ 'getWikiVertical' ] );

		$wfHubMock->expects( $this->once() )
			->method( 'getWikiVertical' )
			->will( $this->returnValue( $vertical ) );

		$this->mockClass( 'WikiFactoryHub', $wfHubMock, 'getInstance' );

		$rightsTextMock = new stdClass();
		$rightsTextMock->cv_value = $rightsText;
		$rightsUrlMock = new stdClass();
		$rightsUrlMock->cv_value = $rightsUrl;

		$this->getStaticMethodMock( 'WikiFactory', 'getVarByName' )
			->expects( $this->any() )
			->method( 'getVarByName' )
			->will( $this->returnValueMap( [
				[ 'wgRightsText', $wikiId, $rightsTextMock ],
				[ 'wgRightsUrl', $wikiId, $rightsUrlMock ],
			] ) );

		$footerModel = new DesignSystemGlobalFooterModel( $wikiId );
		$result = $footerModel->getData();

		$this->assertEquals( $result['licensing_and_vertical'], $expectedResult );
	}

	public function licensingAndVerticalProvider() {
		return [
			[
				'CC-BY-SA',
				'http://www.wikia.com/Licensing',
				[ 'id' => 1, 'short' => 'tv' ],
				[
					'description' => [
						'type' => 'translatable-text',
						'key' => 'wikia-licensing-and-vertical-description',
						'params' => [
							'vertical' => [
								'type' => 'link-text',
								'title' => [
									'type' => 'translatable-text',
									'key' => 'fandom-link-vertical-tv',
								],
								'href' => 'http://fandom.wikia.com/tv',
							],
							'license' => [
								'type' => 'link-text',
								'title' => [
									'type' => 'text',
									'value' => 'CC-BY-SA'
								],
								'href' => 'http://www.wikia.com/Licensing',
							],
						],
					],
				],
			],
			[
				'CC-BY-NC-SA',
				'http://memory-alpha.wikia.com/wiki/Project:Licensing',
				[ 'id' => 1, 'short' => 'movies' ],
				[
					'description' => [
						'type' => 'translatable-text',
						'key' => 'wikia-licensing-and-vertical-description',
						'params' => [
							'vertical' => [
								'type' => 'link-text',
								'title' => [
									'type' => 'translatable-text',
									'key' => 'fandom-link-vertical-movies',
								],
								'href' => 'http://fandom.wikia.com/movies',
							],
							'license' => [
								'type' => 'link-text',
								'title' => [
									'type' => 'text',
									'value' => 'CC-BY-NC-SA'
								],
								'href' => 'http://memory-alpha.wikia.com/wiki/Project:Licensing',
							],
						],
					],
				],
			],
			[
				'CC-BY-SA',
				'http://www.wikia.com/Licensing',
				[ 'id' => 1, 'short' => 'lifestyle' ],
				[
					'description' => [
						'type' => 'translatable-text',
						'key' => 'wikia-licensing-and-vertical-description',
						'params' => [
							'vertical' => [
								'type' => 'line-text',
								'title' => [
									'type' => 'translatable-text',
									'key' => 'fandom-link-vertical-lifestyle',
								],
							],
							'license' => [
								'type' => 'link-text',
								'title' => [
									'type' => 'text',
									'value' => 'CC-BY-SA'
								],
								'href' => 'http://www.wikia.com/Licensing',
							],
						],
					],
				],
			],
			[
				'CC-BY-SA',
				'http://www.wikia.com/Licensing',
				[ 'id' => 0, 'short' => '' ],
				[
					'description' => [
						'type' => 'translatable-text',
						'key' => 'wikia-licensing-description',
						'params' => [
							'license' => [
								'type' => 'link-text',
								'title' => [
									'type' => 'text',
									'value' => 'CC-BY-SA'
								],
								'href' => 'http://www.wikia.com/Licensing',
							],
						],
					],
				],
			],
		];
	}
}
