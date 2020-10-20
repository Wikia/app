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
	public function testGetLicensingAndVertical( $productInstanceId, $product, $server, $sitename, $expectedResult ) {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable('wgCityId', $product);
		$this->mockGlobalVariable( 'wgSitename', $sitename);

		$footerModel = new DesignSystemGlobalFooterModelV2( $product, $productInstanceId, false );
		$result = $footerModel->getData();

		$this->assertEquals( $expectedResult, $result['licensing_and_vertical'] );
	}

	public function getLicensingAndVerticalDataProvider() {
		return [
			[
				1,
				DesignSystemGlobalFooterModelV2::PRODUCT_WIKIS,
				'http://unittest.wikia.com',
				'wikia',
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
						],
					],
				],
			],
			[
				2,
				DesignSystemGlobalFooterModelV2::PRODUCT_WIKIS,
				'http://memory-alpha.wikia.com',
				'memory-alpha',
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
						],
					],
				],
			],
			[
				3,
				DesignSystemGlobalFooterModelV2::PRODUCT_FANDOMS,
				'https://www.fandom.com',
				'Fandom',
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
				DesignSystemGlobalFooterModelV2::PRODUCT_WIKIS,
				'http://test2.wikia.com',
				'wikia',
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
						],
					],
				],
			]
		];
	}

	public function testInternationalHeader() {
		$footerModel = new DesignSystemGlobalFooterModelV2( DesignSystemGlobalFooterModelV2::PRODUCT_WIKIS, 1,false, 'en' );
		$result = $footerModel->getData();

		$this->assertNotEmpty( $result['header'] );
		$this->assertArrayNotHasKey( 'wikia', $result );
		$this->assertArrayNotHasKey( 'fandom', $result );
		$this->assertArrayNotHasKey( 'international_header', $result );

		$footerModel = new DesignSystemGlobalFooterModelV2( DesignSystemGlobalFooterModelV2::PRODUCT_WIKIS, 1, false, 'de' );
		$result = $footerModel->getData();

		$this->assertNotEmpty( $result['header'] );
		$this->assertArrayNotHasKey( 'wikia', $result );
		$this->assertArrayNotHasKey( 'fandom', $result );
		$this->assertArrayNotHasKey( 'international_header', $result );
	}

	public function testGetFandomOverview() {
		$footerModel = new DesignSystemGlobalFooterModelV2( DesignSystemGlobalFooterModelV2::PRODUCT_WIKIS, 1, false, 'en' );
		$result = $footerModel->getData();

		$this->assertCount( 6, $result['fandom_overview']['links'] );

		$footerModel = new DesignSystemGlobalFooterModelV2( DesignSystemGlobalFooterModelV2::PRODUCT_WIKIS, 1, false, 'pl' );
		$result = $footerModel->getData();

		$this->assertCount( 6, $result['fandom_overview']['links'] );
	}

	public function testCorrectMobileAppsTranslationKeys() {
		$footerModel = new DesignSystemGlobalFooterModelV2( DesignSystemGlobalFooterModelV2::PRODUCT_WIKIS, 1, false, 'en' );
		$enLocaleData = $footerModel->getData();

		$this->assertEquals(
			'global-footer-community-apps-header',
			$enLocaleData[ 'fandom_apps' ][ 'header' ][ 'title' ][ 'key' ]
		);
		$this->assertEquals(
			'global-footer-community-apps-description',
			$enLocaleData[ 'fandom_apps' ][ 'description' ][ 'key' ]
		);

		$footerModel = new DesignSystemGlobalFooterModelV2( DesignSystemGlobalFooterModelV2::PRODUCT_WIKIS, 1, false, 'pl' );
		$nonEnLocaleData = $footerModel->getData();

		$this->assertEquals(
			'global-footer-community-apps-header',
			$nonEnLocaleData[ 'fandom_apps' ][ 'header' ][ 'title' ][ 'key' ]
		);
		$this->assertEquals(
			'global-footer-community-apps-description',
			$nonEnLocaleData[ 'fandom_apps' ][ 'description' ][ 'key' ]
		);
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/design_system_global_footer.yaml' );
	}
}
