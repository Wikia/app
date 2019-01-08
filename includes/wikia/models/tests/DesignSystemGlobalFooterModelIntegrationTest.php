<?php

/**
 * @group Integration
 */
class DesignSystemGlobalFooterModelIntegrationTest extends WikiaDatabaseTest {

	/**
	 * @dataProvider getLicensingAndVerticalDataProvider
	 *
	 * @param int $productInstanceId
	 * @param string $product
	 * @param $server
	 * @param $sitename
	 * @param $rightsText license name
	 * @param $rightsUrl license URL
	 * @param $rightsPage
	 * @param $expectedResult
	 */
	public function testGetLicensingAndVertical( $productInstanceId, $product, $server, $sitename, $rightsText, $rightsUrl, $rightsPage, $expectedResult ) {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );

		$footerModel = new DesignSystemGlobalFooterModel( $product, $productInstanceId );
		$result = $footerModel->getData();

		$this->assertEquals( $expectedResult, $result['licensing_and_vertical'] );
	}

	public function getLicensingAndVerticalDataProvider() {
		return [
			[
				1,
				DesignSystemGlobalFooterModel::PRODUCT_WIKIS,
				'http://unittest.wikia.com',
				'wikia',
				'CC-BY-SA',
				'https://www.wikia.com/Licensing',
				'',
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
								'href' => 'https://www.wikia.com/Licensing',
								'tracking_label' => 'license',
							],
						],
					],
				],
			],
			[
				2,
				DesignSystemGlobalFooterModel::PRODUCT_WIKIS,
				'http://memory-alpha.wikia.com',
				'memory-alpha',
				'CC-BY-NC-SA',
				'http://memory-alpha.wikia.com/wiki/Project:Licensing',
				'',
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
								'tracking_label' => 'license',
							],
						],
					],
				],
			],
			[
				3,
				DesignSystemGlobalFooterModel::PRODUCT_FANDOMS,
				'https://www.fandom.com',
				'Fandom',
				'foo',
				'',
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
									'type' => 'translatable-text',
									'key' => 'global-footer-copyright-wikia',
								],
							]
						]
					],
				],

			],
			[
				4,
				DesignSystemGlobalFooterModel::PRODUCT_WIKIS,
				'http://test2.wikia.com',
				'wikia',
				'CC-BY-SA',
				'',
				'w:Wikia:Licensing',
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
								'href' => '//test2.wikia.com/wiki/w:Wikia:Licensing',
								'tracking_label' => 'license',
							],
						],
					],
				],
			]
		];
	}

	public function testInternationalHeader() {
		$footerModel = new DesignSystemGlobalFooterModel( DesignSystemGlobalFooterModel::PRODUCT_WIKIS, 1, 'en' );
		$result = $footerModel->getData();

		$this->assertNotEmpty( $result['header'] );
		$this->assertArrayNotHasKey( 'wikia', $result );
		$this->assertArrayNotHasKey( 'fandom', $result );
		$this->assertArrayNotHasKey( 'international_header', $result );

		$footerModel = new DesignSystemGlobalFooterModel( DesignSystemGlobalFooterModel::PRODUCT_WIKIS, 1, 'de' );
		$result = $footerModel->getData();

		$this->assertNotEmpty( $result['header'] );
		$this->assertArrayNotHasKey( 'wikia', $result );
		$this->assertArrayNotHasKey( 'fandom', $result );
		$this->assertArrayNotHasKey( 'international_header', $result );
	}

	public function testGetFandomOverview() {
		$footerModel = new DesignSystemGlobalFooterModel( DesignSystemGlobalFooterModel::PRODUCT_WIKIS, 1, 'en' );
		$result = $footerModel->getData();

		$this->assertCount( 4, $result['fandom_overview']['links'] );

		$footerModel = new DesignSystemGlobalFooterModel( DesignSystemGlobalFooterModel::PRODUCT_WIKIS, 1, 'pl' );
		$result = $footerModel->getData();

		$this->assertCount( 1, $result['fandom_overview']['links'] );
	}

	public function testCorrectMobileAppsTranslationKeys() {
		$footerModel = new DesignSystemGlobalFooterModel( DesignSystemGlobalFooterModel::PRODUCT_WIKIS, 1, 'en' );
		$enLocaleData = $footerModel->getData();

		$this->assertEquals(
			'global-footer-fandom-app-header',
			$enLocaleData[ 'community_apps' ][ 'header' ][ 'title' ][ 'key' ]
		);
		$this->assertEquals(
			'global-footer-fandom-app-description',
			$enLocaleData[ 'community_apps' ][ 'description' ][ 'key' ]
		);

		$footerModel = new DesignSystemGlobalFooterModel( DesignSystemGlobalFooterModel::PRODUCT_WIKIS, 1, 'pl' );
		$nonEnLocaleData = $footerModel->getData();

		$this->assertEquals(
			'global-footer-community-apps-header',
			$nonEnLocaleData[ 'community_apps' ][ 'header' ][ 'title' ][ 'key' ]
		);
		$this->assertEquals(
			'global-footer-community-apps-description',
			$nonEnLocaleData[ 'community_apps' ][ 'description' ][ 'key' ]
		);
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/design_system_global_footer.yaml' );
	}
}
