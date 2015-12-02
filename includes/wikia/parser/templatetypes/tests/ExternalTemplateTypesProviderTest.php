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
			ExternalTemplateTypesProvider::getInstance()
				->setTCS( new TCSMock( false ) )
				->getTemplateType( $wikiId, $templateId ),
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
			ExternalTemplateTypesProvider::getInstance()
				->setTCS( new TCSMock( true ) )
				->getTemplateType( $wikiId, $templateId ),
			$type
		);
	}

	/**
	 * @param $wikiId
	 * @param $templateId
	 * @param $type
	 *
	 * @dataProvider getTemplateTypeFromCacheDataProvider
	 */
	public function testGetTemplateTypeFromCache( $wikiId, $templateId, $type ) {
		$templateTypesProvider = ExternalTemplateTypesProvider::getInstance();

		// cache type
		$templateTypesProvider->setTCS( new TCSMock( false ) )
			->getTemplateType( $wikiId, $templateId );

		// check if get type is returned from cache
		$this->assertEquals(
			$templateTypesProvider->setTCS( new TCSMock( true ) )
				->getTemplateType( $wikiId, $templateId ),
			$type
		);
	}

	public function getTemplateTypeDataProvider() {
		return [
			[
				12345,
				11111,
				self::TEST_TYPE
			]
		];
	}

	public function getTemplateTypeThrowExceptionDataProvider() {
		return [
			[
				12345,
				22222,
				TemplateClassificationService::TEMPLATE_UNCLASSIFIED
			]
		];
	}

	public function getTemplateTypeFromCacheDataProvider() {
		return [
			[
				12345,
				33333,
				self::TEST_TYPE
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