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
					'title' => 'Service',
					'url' => 'http://service.example.com',
					'name' => 'service',
					'languages:include' => ['en'],
					'languages:exclude' => [],
				],
				'language' => 'en',
				'out' => true,
			],
			[
				'service' => [
					'title' => 'Service',
					'url' => 'http://service.example.com',
					'name' => 'service',
				],
				'language' => 'en',
				'out' => true,
			],
			[
				'service' => [
					'url' => 'http://service.example.com',
					'name' => 'service',
				],
				'language' => 'en',
				'out' => false,
			],
			[
				'service' => [
					'title' => 'Service',
					'name' => 'service',
				],
				'language' => 'en',
				'out' => false,
			],
			[
				'service' => [
					'title' => 'Service',
					'url' => 'http://service.example.com',
				],
				'language' => 'en',
				'out' => false,
			],
			[
				'service' => [
					'title' => 'Service',
					'url' => 'http://service.example.com',
					'name' => 'service',
					'languages:exclude' => ['de'],
				],
				'language' => 'de',
				'out' => false,
			],
			[
				'service' => [
					'title' => 'Service',
					'url' => 'http://service.example.com',
					'name' => 'service',
					'languages:include' => ['en', 'de', 'zh'],
				],
				'language' => 'pl',
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
			PageShareHelper::isValidShareService( $data['service'], $data['language'] )
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
			[ 'bar', null, true, 'pt-br,pt;q=0.8', 'bar' ],
			[ null, 'foo', false, null, 'foo' ],
			[ 'bar', 'foo', false, null, 'bar' ]
		];
	}
}
