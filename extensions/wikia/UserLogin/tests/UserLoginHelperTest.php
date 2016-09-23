<?php
class UserLoginHelperTest extends WikiaBaseTest {

	/**
	 * @dataProvider getNewAuthUrlDataProvider
	 */
	public function testGetNewAuthUrl( $page, $requestUrl, $contLangCode, $expected ) {
		$titleMock = $this->getMock( Title::class, [ 'isSpecial' ] );
		$titleMock->expects( $this->once() )->method( 'isSpecial' )->willReturn( false );

		$webRequestMock = $this->getMock( WebRequest::class, [ 'getRequestURL' ] );
		$webRequestMock->expects( $this->once() )->method( 'getRequestURL' )->willReturn( $requestUrl );

		$languageMock = $this->getMock( Language::class );
		$languageMock->mCode = $contLangCode;

		$this->mockGlobalVariable( 'wgTitle', $titleMock );
		$this->mockGlobalVariable( 'wgRequest', $webRequestMock );
		$this->mockGlobalVariable( 'wgContLang', $languageMock );

		$userLoginHelper = new UserLoginHelper();

		$authUrl = $userLoginHelper->getNewAuthUrl( $page );

		$this->assertEquals( $expected, $authUrl );
	}

	public function getNewAuthUrlDataProvider() {
		return [
			[ '/join', 'http://www.wikia.com', 'en', '/join?redirect=http%3A%2F%2Fwww.wikia.com' ],
			[ '/join', 'http://www.wikia.com', 'pl', '/join?redirect=http%3A%2F%2Fwww.wikia.com&uselang=pl' ],
			[ '/signin', 'http://www.wikia.com', 'pl', '/signin?redirect=http%3A%2F%2Fwww.wikia.com&uselang=pl' ],
			[
				'/signin',
				'http://fallout.wikia.com',
				'pl',
				'/signin?redirect=http%3A%2F%2Ffallout.wikia.com&uselang=pl'
			],
			[
				'https://www.wikia.com/register',
				'http://www.wikia.com',
				'en',
				'https://www.wikia.com/register?redirect=http%3A%2F%2Fwww.wikia.com'
			],
			[
				'https://www.wikia.com/register',
				'http://www.wikia.com',
				'de',
				'https://www.wikia.com/register?redirect=http%3A%2F%2Fwww.wikia.com&uselang=de'
			],
			[
				'https://www.wikia.com/register?uselang=de',
				'http://www.wikia.com',
				'de',
				'https://www.wikia.com/register?uselang=de&redirect=http%3A%2F%2Fwww.wikia.com'
			],
			[
				'https://www.wikia.com/register?uselang=pl',
				'http://www.wikia.com',
				'es',
				'https://www.wikia.com/register?uselang=pl&redirect=http%3A%2F%2Fwww.wikia.com'
			],
		];
	}
}
