<?php

class PageShareHelperTest extends WikiaBaseTest {

	protected function setUp () {
		require_once( __DIR__ . '/../PageShareHelper.class.php' );
		parent::setUp();
	}

	public function IsValidShareServiceProvider() {
		return [
			[
				'service' => [
					'name' => 'service',
					'languages:include' => ['en'],
					'languages:exclude' => [],
				],
				'language' => 'en',
				'isTouchScreen' => 0,
				'out' => true,
			],
			[
				'service' => [
					'name' => 'service',
				],
				'language' => 'en',
				'isTouchScreen' => 0,
				'out' => true,
			],
			[
				'service' => [
					'name' => 'service',
				],
				'language' => 'ja',
				'isTouchScreen' => 1,
				'out' => true,
			],
			[
				'service' => [
					'name' => 'service',
				],
				'language' => 'ja',
				'isTouchScreen' => 0,
				'out' => false,
			],
			[
				'service' => [
					'name' => 'service',
				],
				'language' => 'en',
				'isTouchScreen' => 0,
				'out' => false,
			],
			[
				'service' => [
					'name' => 'service',
				],
				'language' => 'en',
				'isTouchScreen' => 0,
				'out' => false,
			],
			[
				'service' => [
				],
				'language' => 'en',
				'isTouchScreen' => 0,
				'out' => false,
			],
			[
				'service' => [
					'name' => 'service',
					'languages:exclude' => ['de'],
				],
				'language' => 'de',
				'isTouchScreen' => 0,
				'out' => false,
			],
			[
				'service' => [
					'name' => 'service',
					'languages:include' => ['en', 'de', 'zh'],
				],
				'language' => 'pl',
				'isTouchScreen' => 0,
				'out' => false,
			],
		];
	}


	/**
	 * @dataProvider IsValidShareServiceProvider
	 */
	public function testIsValidShareService( $data ) {
		$this->assertEquals(
			$data['out'],
			PageShareHelper::isValidShareService( $data['service'], $data['language'], $data['isTouchScreen'] )
		);
	}

	/**
	 * @dataProvider getLangForPageShareDataProvider
	 * @param $requestShareLang
	 * @param $useLang
	 * @param $expectedResult
	 */
	public function testGetLangForPageShare( $requestShareLang, $useLang, $expectedResult ) {
		$this->assertEquals( $expectedResult, PageShareHelper::getLangForPageShare( $requestShareLang, $useLang ) );
	}

	/**
	 * Data provider for testGetLangForPageShare.
	 *
	 * Arguments represent following values:
	 * 1 - $requestShareLang, language requested from client side
	 * 2 - $useLang, uselang query string parameter value
	 * 3 - $expectedResult, expected result
	 *
	 * First set - client didn't request any language and didn't provide ?uselang=xx query string parameter,
	 *             return default language defined in SHARE_DEFAULT_LANGUAGE
	 * Second set - language is provided by client
	 * Third set - language is taken from ?uselang=xx
	 * Fourth set - language is provided by client, but it's overwritten by ?uselang=xx
	 *
	 * @return array
	 */
	public function getLangForPageShareDataProvider() {
		return [
			[ null, null, 'en' ],
			[ 'zh', null, 'zh' ],
			[ null, 'ru', 'ru' ],
			[ 'de', 'ja', 'ja' ]
		];
	}
}
