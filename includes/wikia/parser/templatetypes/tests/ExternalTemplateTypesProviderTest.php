<?php

use Swagger\Client\ApiException;

class ExternalTemplateTypesProviderTest extends WikiaBaseTest {
	const TEST_TYPE = 'test-type';

	/**
	 * @param $wikiId
	 * @param $templateId
	 * @param $type
	 *
	 * @dataProvider getTemplateTypeDataProvider
	 */
	public function testGetTemplateType( $wikiId, $templateId, $type ) {
		$this->assertEquals(
			( new ExternalTemplateTypesProvider( new TCSMock() ) )->getTemplateType( $wikiId, $templateId ),
			$type
		);
	}

	/**
	 * @param $wikiId
	 * @param $templateId
	 * @param $type
	 *
	 * @dataProvider getTemplateTypeThrowExceptionDataProvider
	 */
	public function testGetTemplateTypeThrowException( $wikiId, $templateId, $type ) {
		$this->assertEquals(
			( new ExternalTemplateTypesProvider( new TCSMock( true ) ) )->getTemplateType( $wikiId, $templateId ),
			$type
		);
	}

	public function getTemplateTypeDataProvider() {
		return [
			[
				12345,
				12345,
				self::TEST_TYPE
			]
		];
	}

	public function getTemplateTypeThrowExceptionDataProvider() {
		return [
			[
				12345,
				12345,
				TemplateClassificationService::TEMPLATE_UNCLASSIFIED
			]
		];
	}
}

class TCSMock {
	private $shouldThrow;

	function __construct( $shouldThrow = false ) {
		$this->shouldThrow = $shouldThrow;
	}

	public function getType() {
		if ( $this->shouldThrow ) {
			throw new ApiException();
		}

		return ExternalTemplateTypesProviderTest::TEST_TYPE;
	}
}