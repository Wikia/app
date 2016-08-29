<?php

class DesignSystemGlobalFooterWikiModelTest extends WikiaBaseTest {
	/**
	 * @dataProvider getLicensingAndVerticalDataProvider
	 *
	 * @param $sitename
	 * @param $rightsText license name
	 * @param $rightsUrl license URL
	 * @param $expectedResult
	 */
	public function testGetLicensingAndVertical( $sitename, $rightsText, $rightsUrl, $expectedResult ) {
		$wikiId = 1234;

		$this->getStaticMethodMock( 'WikiFactory', 'getVarValueByName' )
			->expects( $this->any() )
			->method( 'getVarValueByName' )
			->will( $this->returnValueMap( [
				[ 'wgRightsText', $wikiId, $rightsText ],
				[ 'wgRightsUrl', $wikiId, $rightsUrl ],
				[ 'wgSitename', $wikiId, $sitename ]
			] ) );

		$footerModel = new DesignSystemGlobalFooterWikiModel( $wikiId );
		$result = $footerModel->getData();

		$this->assertEquals( $result['licensing_and_vertical'], $expectedResult );
	}

	public function getLicensingAndVerticalDataProvider() {
		return [
			[
				'wikia',
				'CC-BY-SA',
				'http://www.wikia.com/Licensing',
				[
					'description' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-licensing-and-vertical-description',
						'params' => [
							'sitename' => [
								'type' => 'text',
								'value' => 'wikia'
							],
							'vertical' => [
								'type' => 'translatable-text',
								'key' => 'global-footer-licensing-and-vertical-description-param-vertical-lifestyle'
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
				'memory-alpha',
				'CC-BY-NC-SA',
				'http://memory-alpha.wikia.com/wiki/Project:Licensing',
				[
					'description' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-licensing-and-vertical-description',
						'params' => [
							'sitename' => [
								'type' => 'text',
								'value' => 'memory-alpha'
							],
							'vertical' => [
								'type' => 'translatable-text',
								'key' => 'global-footer-licensing-and-vertical-description-param-vertical-lifestyle'
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
		];
	}

	/**
	 * @dataProvider getHrefDataProvider
	 *
	 * @param string $lang language code to fetch
	 * @param array $hrefs hrefs definition in different languages
	 * @param array $expectedResult
	 */
	public function testGetHref( $lang, $hrefs, $expectedResult ) {
		$footerModel = new DesignSystemGlobalFooterWikiModel( 1234, $lang );
		$footerModel->setHrefs( $hrefs );

		$result = $footerModel->getData();

		$this->assertEquals( $result['create_wiki']['links'][0]['href'], $expectedResult );
	}

	public function getHrefDataProvider() {
		return [
			[
				'pl',
				[
					'en' => [
						'create-new-wiki' => 'http://www.wikia.com'
					],
					'default' => [
						'create-new-wiki' => 'http://www.example.com'
					],
					'pl' => [
						'create-new-wiki' => 'http://www.wikia.pl'
					],
				],
				'http://www.wikia.pl'
			],
			[
				'pl',
				[
					'en' => [
						'create-new-wiki' => 'http://www.wikia.com'
					],
					'default' => [
						'create-new-wiki' => 'http://www.example.com'
					],
					'pl' => [],
				],
				'http://www.example.com'
			],
			[
				'pl',
				[
					'en' => [
						'create-new-wiki' => 'http://www.wikia.com'
					],
					'default' => [
						'create-new-wiki' => null
					],
					'pl' => [],
				],
				null
			],
			[
				'en',
				[
					'en' => [
						'create-new-wiki' => 'http://www.wikia.com'
					],
					'default' => [
						'create-new-wiki' => null
					],
					'pl' => [],
				],
				'http://www.wikia.com'
			],
		];
	}

	public function testInternationalHeader() {
		$footerModel = new DesignSystemGlobalFooterWikiModel( 1234, 'en' );
		$result = $footerModel->getData();

		$this->assertNotEmpty( $result['wikia'] );
		$this->assertNotEmpty( $result['fandom'] );
		$this->assertArrayNotHasKey( 'international_header', $result );

		$footerModel = new DesignSystemGlobalFooterWikiModel( 1234, 'de' );
		$result = $footerModel->getData();

		$this->assertNotEmpty( $result['international_header'] );
		$this->assertArrayNotHasKey( 'wikia', $result );
		$this->assertArrayNotHasKey( 'fandom', $result );
	}

	public function testGetFandomOverview() {
		$footerModel = new DesignSystemGlobalFooterWikiModel( 1234, 'en' );
		$result = $footerModel->getData();

		$this->assertCount( 4, $result['fandom_overview']['links'] );

		$footerModel = new DesignSystemGlobalFooterWikiModel( 1234, 'pl' );
		$result = $footerModel->getData();

		$this->assertCount( 1, $result['fandom_overview']['links'] );
	}

	/**
	 * @dataProvider getFollowUsDataProvider
	 *
	 * @param $lang language code to fetch
	 * @param $hrefs hrefs definition in different languages
	 * @param $expectedCount
	 */
	public function testGetFollowUs( $lang, $hrefs, $expectedCount ) {
		$footerModel = new DesignSystemGlobalFooterWikiModel( 1234, $lang );
		$footerModel->setHrefs( $hrefs );

		$result = $footerModel->getData();
		$this->assertCount( $expectedCount, $result['follow_us']['links'] );
	}

	public function getFollowUsDataProvider() {
		return [
			[
				'de',
				[
					'default' => [
						'social-facebook' => 'http://facebook.com',
						'social-youtube' => 'http://youtube.com',
						'social-twitter' => 'http://twitter.com',
						'social-instagram' => 'http://instagram.com',
						'social-reddit' => 'http://reddit.com'
					],
					'de' => [
						'social-facebook' => 'http://facebook.com',
						'social-youtube' => 'http://youtube.com',
						'social-twitter' => 'http://twitter.com',
					],
				],
				5
			],
			[
				'de',
				[
					'default' => [
						'social-facebook' => 'http://facebook.com',
						'social-youtube' => 'http://youtube.com',
						'social-twitter' => 'http://twitter.com',
						'social-instagram' => null,
						'social-reddit' => null
					],
					'de' => [
						'social-facebook' => 'http://facebook.com',
						'social-youtube' => 'http://youtube.com',
						'social-twitter' => 'http://twitter.com',
					],
				],
				3
			],
			[
				'de',
				[
					'default' => [
						'social-facebook' => null,
						'social-youtube' => null,
						'social-twitter' => null,
						'social-instagram' => null,
						'social-reddit' => null
					],
					'de' => [
					],
				],
				0
			],
		];
	}
}
