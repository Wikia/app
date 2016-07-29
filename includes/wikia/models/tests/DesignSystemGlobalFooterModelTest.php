<?php

class DesignSystemGlobalFooterModelTest extends WikiaBaseTest {
	/**
	 * @dataProvider getLicenseDataDataProvider
	 *
	 * @param $rightsText license name
	 * @param $rightsUrl license URL
	 * @param $expectedResult
	 */
	public function testGetLicenseData( $rightsText, $rightsUrl, $expectedResult ) {
		$wikiId = 1234;

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

	public function getLicenseDataDataProvider() {
		return [
			[
				'CC-BY-SA',
				'http://www.wikia.com/Licensing',
				[
					'description' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-licensing-description',
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
			[
				'CC-BY-NC-SA',
				'http://memory-alpha.wikia.com/wiki/Project:Licensing',
				[
					'description' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-licensing-description',
						'params' => [
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
	 * @param $lang language code to fetch
	 * @param $hrefs hrefs definition in different languages
	 * @param $expectedResult
	 */
	public function testGetHref( $lang, $hrefs, $expectedResult ) {
		$footerModel = new DesignSystemGlobalFooterModel( 1234, $lang );
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
					'pl' => [ ],
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
					'pl' => [ ],
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
					'pl' => [ ],
				],
				'http://www.wikia.com'
			],
		];
	}

	public function testInternationalHeader() {
		$footerModel = new DesignSystemGlobalFooterModel( 1234, 'en' );
		$result = $footerModel->getData();

		$this->assertNotEmpty( $result['wikia'] );
		$this->assertNotEmpty( $result['fandom'] );
		$this->assertArrayNotHasKey( 'international_header', $result );

		$footerModel = new DesignSystemGlobalFooterModel( 1234, 'de' );
		$result = $footerModel->getData();

		$this->assertNotEmpty( $result['international_header'] );
		$this->assertArrayNotHasKey( 'wikia', $result );
		$this->assertArrayNotHasKey( 'fandom', $result );
	}

	public function testGetFandomOverview() {
		$footerModel = new DesignSystemGlobalFooterModel( 1234, 'en' );
		$result = $footerModel->getData();

		$this->assertCount( 4, $result['fandom_overview']['links'] );

		$footerModel = new DesignSystemGlobalFooterModel( 1234, 'pl' );
		$result = $footerModel->getData();

		$this->assertCount( 1, $result['fandom_overview']['links'] );
	}

	/**
	 * @dataProvider getLinksDataProvider
	 *
	 * @param string $lang language code to fetch
	 * @param array $hrefs hrefs definition in different languages
	 * @param array $baseData data template before parsing hrefs
	 * @param array $expected
	 */
	public function testGetLinksData( $lang, $hrefs, $baseData, $expected ) {
		$footerModel = new DesignSystemGlobalFooterModel( 1234, $lang );
		$footerModel->setHrefs( $hrefs );
		$footerModel->setBaseData( $baseData );

		$result = $footerModel->getData();

		$this->assertEquals( $expected, $result['follow_us']['links'] );
	}

	public function getLinksDataProvider() {
		$baseData = [
			'follow_us' => [
				'header' => 'header data',
				'links' => [
					[
						'href-key' => 'social-facebook',
						'other-key' => 'foo'
					],
					[
						'href-key' => 'social-twitter',
						'other-key' => 'bar'
					],
					[
						'href-key' => 'social-reddit',
						'other-key' => 'baz'
					],
					[
						'href-key' => 'social-youtube',
						'other-key' => 'qux'
					],
					[
						'href-key' => 'social-instagram',
						'other-key' => 'quux'
					],
				],
			],
		];

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
						'social-facebook' => 'http://de.facebook.com',
						'social-youtube' => 'http://de.youtube.com',
						'social-twitter' => 'http://de.twitter.com',
					],
				],
				$baseData,
				[
					[
						'href' => 'http://de.facebook.com',
						'other-key' => 'foo'
					],
					[
						'href' => 'http://de.twitter.com',
						'other-key' => 'bar'
					],
					[
						'href' => 'http://reddit.com',
						'other-key' => 'baz'
					],
					[
						'href' => 'http://de.youtube.com',
						'other-key' => 'qux'
					],
					[
						'href' => 'http://instagram.com',
						'other-key' => 'quux'
					],
				],
			],
			[
				'pl',
				[
					'default' => [
						'social-facebook' => 'http://facebook.com',
						'social-youtube' => 'http://youtube.com',
						'social-twitter' => 'http://twitter.com',
						'social-instagram' => null,
						'social-reddit' => null
					],
					'pl' => [
						'social-facebook' => 'http://pl.facebook.com',
						'social-youtube' => 'http://pl.youtube.com',
						'social-twitter' => 'http://pl.twitter.com',
					],
				],
				$baseData,
				[
					[
						'href' => 'http://pl.facebook.com',
						'other-key' => 'foo'
					],
					[
						'href' => 'http://pl.twitter.com',
						'other-key' => 'bar'
					],
					[
						'href' => 'http://pl.youtube.com',
						'other-key' => 'qux'
					],
				],
			],
			[
				'fr',
				[
					'default' => [
						'social-facebook' => null,
						'social-youtube' => null,
						'social-twitter' => null,
						'social-instagram' => null,
						'social-reddit' => null
					],
					'fr' => [
					],
				],
				$baseData,
				null
			],
		];
	}
}
