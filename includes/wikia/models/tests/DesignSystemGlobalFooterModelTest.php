<?php

class DesignSystemGlobalFooterModelTest extends WikiaBaseTest {
	/**
	 * @dataProvider getLicensingAndVerticalDataProvider
	 *
	 * @param $sitename
	 * @param $rightsText license name
	 * @param $rightsUrl license URL
	 * @param $expectedResult
	 */
	public function testGetLicensingAndVertical( $product, $sitename, $rightsText, $rightsUrl, $expectedResult ) {
		$productInstanceId = 1234;

		$this->getStaticMethodMock( 'WikiFactory', 'getVarValueByName' )
			->expects( $this->any() )
			->method( 'getVarValueByName' )
			->will( $this->returnValueMap( [
				[ 'wgRightsText', $productInstanceId, $rightsText ],
				[ 'wgRightsUrl', $productInstanceId, $rightsUrl ],
				[ 'wgSitename', $productInstanceId, $sitename ]
			] ) );

		$footerModel = new DesignSystemGlobalFooterModel( $product, $productInstanceId );
		$result = $footerModel->getData();

		$this->assertEquals( $result['licensing_and_vertical'], $expectedResult );
	}

	public function getLicensingAndVerticalDataProvider() {
		return [
			[
				DesignSystemGlobalFooterModel::PRODUCT_WIKIS,
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
				DesignSystemGlobalFooterModel::PRODUCT_WIKIS,
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
			[
				DesignSystemGlobalFooterModel::PRODUCT_FANDOMS,
				'Fandom',
				'foo',
				'',
				'licensing_and_vertical' => [
					'description' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-licensing-and-vertical-description',
						'params' => [
							'sitename' => [
								'type' => 'text',
								'value' => 'Fandom',
							],
							'vertical' => [],
							'license' => [
								'type' => 'line-text',
								'title' => [
									'type' => 'text',
									'key' => 'global-footer-copyright-wikia',
								],
							]
						]
					],
				],

			]
		];
	}

	/**
	 * @dataProvider getHrefDataProvider
	 *
	 * @param string $lang language code to fetch
	 * @param array $hrefs hrefs definition in different languages
	 * @param string $expectedResult
	 */
	public function testGetHref( $product, $lang, $hrefs, $expectedResult ) {
		$footerModel = new DesignSystemGlobalFooterModel( $product, 1234, $lang );
		$footerModel->setHrefs( $hrefs );

		$result = $footerModel->getData();

		$this->assertEquals( $result['create_wiki']['links'][0]['href'], $expectedResult );
	}

	public function getHrefDataProvider() {
		return [
			[
				DesignSystemGlobalFooterModel::PRODUCT_WIKIS,
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
				DesignSystemGlobalFooterModel::PRODUCT_WIKIS,
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
				DesignSystemGlobalFooterModel::PRODUCT_WIKIS,
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
				DesignSystemGlobalFooterModel::PRODUCT_WIKIS,
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
			[
				DesignSystemGlobalFooterModel::PRODUCT_FANDOMS,
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
		];
	}

	public function testInternationalHeader() {
		$footerModel = new DesignSystemGlobalFooterModel( DesignSystemGlobalFooterModel::PRODUCT_WIKIS, 1234, 'en' );
		$result = $footerModel->getData();

		$this->assertNotEmpty( $result['wikia'] );
		$this->assertNotEmpty( $result['fandom'] );
		$this->assertArrayNotHasKey( 'international_header', $result );

		$footerModel = new DesignSystemGlobalFooterModel( DesignSystemGlobalFooterModel::PRODUCT_WIKIS, 1234, 'de' );
		$result = $footerModel->getData();

		$this->assertNotEmpty( $result['international_header'] );
		$this->assertArrayNotHasKey( 'wikia', $result );
		$this->assertArrayNotHasKey( 'fandom', $result );
	}

	public function testGetFandomOverview() {
		$footerModel = new DesignSystemGlobalFooterModel( DesignSystemGlobalFooterModel::PRODUCT_WIKIS, 1234, 'en' );
		$result = $footerModel->getData();

		$this->assertCount( 4, $result['fandom_overview']['links'] );

		$footerModel = new DesignSystemGlobalFooterModel( DesignSystemGlobalFooterModel::PRODUCT_WIKIS, 1234, 'pl' );
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
		$footerModel = new DesignSystemGlobalFooterModel( DesignSystemGlobalFooterModel::PRODUCT_WIKIS, 1234, $lang );
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
