<?php

class DesignSystemGlobalFooterModelTest extends WikiaBaseTest {
	/**
	 * @dataProvider getLicensingAndVerticalDataProvider
	 *
	 * @param string $product
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
}
