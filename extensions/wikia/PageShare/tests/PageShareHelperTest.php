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
	 * @param $requestLang
	 * @param $langCode
	 * @param $isAnon
	 * @param $acceptLanguageHeaderExists
	 * @param $acceptLanguageHeader
	 * @param $expectedResult
	 */
	public function testGetLangForPageShare(
		$requestLang, $langCode, $isAnon, $browserLang, $expectedResult
	) {
		$wgLangMock = $this->getMock( 'Language', [ 'getCode' ] );
		$wgLangMock->expects( $this->any() )
			->method( 'getCode' )
			->will( $this->returnValue( $langCode ) );
		$this->mockGlobalVariable( 'wgLang', $wgLangMock );

		$wgUserMock = $this->getMock( 'User', [ 'isAnon' ] );
		$wgUserMock->expects( $this->any() )
			->method( 'isAnon' )
			->will( $this->returnValue( $isAnon ) );
		$this->mockGlobalVariable( 'wgUser', $wgUserMock );

		$this->assertEquals( $expectedResult, PageShareHelper::getLangForPageShare($browserLang, $requestLang) );
	}

	/**
	 * Data provider for testGetLangForPageShare.
	 *
	 * Arguments represent following values:
	 * 1 - $requestLang, uselang parameter value
	 * 2 - $langCode, $wgLang->getCode value
	 * 3 - $isAnon, $wgUser->isAnon() value
	 * 4 - $browserLang, window,navigator.language value
	 * 5 - $expectedResult, expected result
	 *
	 * First set - anon user, language should be taken from browser language
	 * Second set - anon user, browser language is set to "falsy" value, return default language defined in SHARE_DEFAULT_LANGUAGE
	 * Third set - anon user, language is overwritten by ?uselang=xx
	 * Fourth set - logged in user, language is taken from user language
	 * Fifth set - logged in user, language is overwritten by ?uselang=xx
	 *
	 * @return array
	 */
	public function getLangForPageShareDataProvider() {
		return [
			[ null, null, true, 'pl', 'pl' ],
			[ null, null, true, false, 'en' ],
			[ 'zh', null, true, 'pt', 'zh' ],
			[ null, 'ru', false, null, 'ru' ],
			[ 'ja', 'fr', false, null, 'ja' ]
		];
	}
}
