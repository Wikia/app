<?php
/**
 * Class definition for Wikia\Search\Test\Language\LanguageServiceTest
 */
namespace Wikia\Search\Language;

use Wikia\Search\Test\BaseTest;

/**
 * Tests Wikia\Search\Language classes
 */
class LanguageServiceTest extends BaseTest {

	/**
	 * @dataProvider getDefaultThresholdDataProvider
	 */
	public function testGetWikiArticlesThreshold( $languageCode, $expThreshold ) {
		$service = new LanguageService();
		$service->setLanguageCode( $languageCode );

		$this->assertEquals( $expThreshold, $service->getWikiArticlesThreshold() );
	}

	public function getDefaultThresholdDataProvider() {
		return [
			[ 'en', 50 ],
			[ 'ja', 0 ],
			[ 'pl', 25 ],
			[ 'de', 25 ]
		];
	}
}
