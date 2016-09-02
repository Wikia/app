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

		$footerModel = new DesignSystemGlobalFooterModel( $wikiId );
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
}
