<?php

class DesignSystemGlobalFooterModelTest extends WikiaBaseTest {
	/**
	 * @dataProvider setLicensingAndVerticalDataProvider
	 *
	 * @param $rightsText license name
	 * @param $rightsUrl license URL
	 * @param $expectedResult
	 */
	public function testSetLicensingAndVertical( $rightsText, $rightsUrl, $expectedResult ) {
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

	public function setLicensingAndVerticalDataProvider() {
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
		];
	}
}
