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
		$requestLang, $langCode, $isAnon, $acceptLanguageHeaderExists, $acceptLanguageHeader, $expectedResult
	) {
		if ( $acceptLanguageHeaderExists ) {
			$_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] = $acceptLanguageHeader;
		} else {
			unset( $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] );
		}

		$wgRequestMock = $this->getMock( 'WebRequest', [ 'getVal' ] );
		$wgRequestMock->expects( $this->any() )
			->method( 'getVal' )
			->will( $this->returnCallback( function ( $key, $defaultValue ) use ( $requestLang ) {
				if ( !is_null( $requestLang ) ) {
					return $requestLang;
				} ;
				return $defaultValue;
			} ) );
		$this->mockGlobalVariable( 'wgRequest', $wgRequestMock );

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

		$this->assertEquals( $expectedResult, PageShareHelper::getLangForPageShare() );
	}

	/**
	 * Data provider for testGetLangForPageShare.
	 *
	 * First set - anon user, language should be taken from HTTP_ACCEPT_LANGUAGE header
	 * Second set - anon user, HTTP_ACCEPT_LANGUAGE header is not set, return default language defined in SHARE_DEFAULT_LANGUAGE
	 * Third set - anon user, HTTP_ACCEPT_LANGUAGE header is set but is "falsy", return default language defined in SHARE_DEFAULT_LANGUAGE
	 * Fourth set - anon user, language is overwritten by ?uselang=xx
	 * Fifth set - logged in user, language is taken from user language
	 * Sixth set - logged in user, language is overwritten by ?uselang=xx
	 *
	 * @return array
	 */
	public function getLangForPageShareDataProvider() {
		return [
			[ null, null, true, true, 'pl,pl;q=0.8', 'pl' ],
			[ null, null, true, false, 'pt-br,pt;q=0.8', 'en' ],
			[ null, null, true, true, false, 'en' ],
			[ 'bar', null, true, true, 'pt-br,pt;q=0.8', 'bar' ],
			[ null, 'foo', false, false, null, 'foo' ],
			[ 'bar', 'foo', false, false, null, 'bar' ]
		];
	}
}
