<?php

class PageShareHelperTest extends WikiaBaseTest {

	protected function setUp () {
		require_once( __DIR__ . '/../PageShareHelper.class.php' );
		parent::setUp();
	}

	/**
	 * @dataProvider IsValidShareServiceDataProvider
	 */
	public function testIsValidShareService( $data, $expectedResult ) {
		$this->assertEquals(
			$expectedResult,
			PageShareHelper::isValidShareService( $data['service'], $data['language'], $data['isTouchScreen'] )
		);
	}

	public function IsValidShareServiceDataProvider() {
		return [
			[
				[
					'service' => [
						'name' => 'service name',
						'title' => 'service title',
						'href' => 'service href'
					],
					'language' => 'en',
					'isTouchScreen' => 0
				],
				true
			],
			[
				[
					'service' => [
						'title' => 'service title',
						'href' => 'service href'
					],
					'language' => 'en',
					'isTouchScreen' => 0
				],
				false
			],
			[
				[
					'service' => [
						'name' => 'service name',
						'href' => 'service href'
					],
					'language' => 'en',
					'isTouchScreen' => 0
				],
				false
			],
			[
				[
					'service' => [
						'name' => 'service name',
						'title' => 'service title'
					],
					'language' => 'en',
					'isTouchScreen' => 0
				],
				false
			],
			[
				[
					'service' => [
						'name' => 'service name',
						'title' => 'service title',
						'href' => 'service href',
						'languages:include' => ['en', 'pl', 'de'],
						'languages:exclude' => ['ru', 'es']
					],
					'language' => 'en',
					'isTouchScreen' => 0
				],
				true
			],
			[
				[
					'service' => [
						'name' => 'service name',
						'title' => 'service title',
						'href' => 'service href',
						'languages:include' => ['en', 'pl', 'de'],
						'languages:exclude' => ['ru', 'es']
					],
					'language' => 'ru',
					'isTouchScreen' => 0
				],
				false
			],
			[
				[
					'service' => [
						'name' => 'service name',
						'title' => 'service title',
						'href' => 'service href',
						'languages:include' => ['en', 'de', 'zh']
					],
					'language' => 'pl',
					'isTouchScreen' => 0
				],
				false
			],
			[
				[
					'service' => [
						'name' => 'service name',
						'title' => 'service title',
						'href' => 'service href',
						'languages:exclude' => ['ru', 'de', 'fr']
					],
					'language' => 'de',
					'isTouchScreen' => 0
				],
				false
			],
			[
				[
					'service' => [
						'name' => 'service name',
						'title' => 'service title',
						'href' => 'service href'
					],
					'language' => 'en',
					'isTouchScreen' => 1
				],
				true
			],
			[
				[
					'service' => [
						'name' => 'service name',
						'title' => 'service title',
						'href' => 'service href',
						'displayOnlyOnTouchDevices' => true
					],
					'language' => 'ja',
					'isTouchScreen' => 1
				],
				true
			],
			[
				[
					'service' => [
						'name' => 'service name',
						'title' => 'service title',
						'href' => 'service href',
						'displayOnlyOnTouchDevices' => true
					],
					'language' => 'ja',
					'isTouchScreen' => 0
				],
				false
			]
		];
	}

	/**
	 * @dataProvider getLangForPageShareDataProvider
	 * @param $requestShareLang
	 * @param $expectedResult
	 */
	public function testGetLangForPageShare( $requestShareLang, $expectedResult ) {
		$this->assertEquals( $expectedResult, PageShareHelper::getLangForPageShare( $requestShareLang ) );
	}

	/**
	 * Data provider for testGetLangForPageShare.
	 *
	 * Arguments represent following values:
	 * $requestShareLang - language requested from client side
	 * $expectedResult - Nobody expects the Spanish Inquisition!
	 *
	 * First set - client didn't request any language, return default language defined in SHARE_DEFAULT_LANGUAGE
	 * Second set - language is provided by client
	 * Third set - language is provided by Worf
	 *
	 * @return array
	 */
	public function getLangForPageShareDataProvider() {
		return [
			[ null, 'en' ],
			[ 'pl', 'pl' ],
			[ 'Klingon', 'Klingon' ]
		];
	}
}
