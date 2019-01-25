<?php

use PHPUnit\Framework\MockObject\MockObject;

class CategoryPage3HooksTest extends WikiaBaseTest {
	const ORIGINAL_LINK = 'original-link';

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../CategoryPage3Hooks.class.php';
		parent::setUp();
	}

	/**
	 * @dataProvider onArticleFromTitleDataProvider
	 *
	 * @param bool $isCategory
	 * @param bool $isAnon
	 * @param bool $isCategoryExhibitionDisabledForTitle
	 * @param $cookie
	 * @param $preference
	 * @param $expectedClass
	 * @param string $message
	 */
	public function testOnArticleFromTitle(
		bool $isCategory,
		bool $isAnon,
		bool $isCategoryExhibitionDisabledForTitle,
		$cookie,
		$preference,
		$expectedClass,
		string $message
	) {
		// Mock request
		$requestMock = $this->getMockBuilder( 'WebRequest' )
			->disableOriginalConstructor()
			->setMethods( [ 'getCookie' ] )
			->getMock();

		$requestMock->expects( $this->atMost( 1 ) )
			->method( 'getCookie' )
			->willReturn( $cookie );

		// Mock user
		$userMock = $this->getMockBuilder( 'User' )
			->disableOriginalConstructor()
			->setMethods( [ 'getGlobalPreference', 'isAnon' ] )
			->getMock();

		$userMock->expects( $this->atMost( 1 ) )
			->method( 'getGlobalPreference' )
			->willReturnCallback( function ( $_, $default ) use ( $preference ) {
				return empty( $preference ) ? $default : $preference;
			} );

		$userMock->expects( $this->atMost( 1 ) )
			->method( 'isAnon' )
			->willReturn( $isAnon );

		// Mock context
		$contextMock = $this->getMockBuilder( 'RequestContext' )
			->disableOriginalConstructor()
			->setMethods( [ 'getRequest', 'getUser' ] )
			->getMock();

		$contextMock->expects( $this->atMost( 1 ) )
			->method( 'getRequest' )
			->willReturn( $requestMock );

		$contextMock->expects( $this->atMost( 1 ) )
			->method( 'getUser' )
			->willReturn( $userMock );

		// Mock title
		/** @var Title|MockObject $titleMock */
		$titleMock = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( [ 'inNamespace' ] )
			->getMock();

		$titleMock->expects( $this->once() )
			->method( 'inNamespace' )
			->willReturn( $isCategory );

		// Mock article
		/** @var Article|MockObject $articleMock */
		$articleMock = $this->getMockBuilder( 'Article' )
			->disableOriginalConstructor()
			->setMethods( [ 'getPage', 'getContext' ] )
			->getMock();

		$articleMock->expects( $this->atMost( 1 ) )
			->method( 'getPage' )
			->willReturn( new WikiPage( $titleMock ) );

		$articleMock->expects( $this->atMost( 1 ) )
			->method( 'getContext' )
			->willReturn( $contextMock );

		$this->mockStaticMethod(
			'CategoryExhibitionHooks',
			'isExhibitionDisabledForTitle',
			$isCategoryExhibitionDisabledForTitle
		);

		// Run
		CategoryPage3Hooks::onArticleFromTitle( $titleMock, $articleMock );

		// Assert
		$this->assertInstanceOf( $expectedClass, $articleMock, $message );
	}

	public function onArticleFromTitleDataProvider(): Generator {
		// $isCategory
		// $isAnon
		// $isCategoryExhibitionDisabledForTitle
		// $cookie
		// $preference
		// $expectedClass
		// $message
		yield [
			true,
			true,
			false,
			'mediawiki',
			null,
			CategoryPage3::class,
			'Category NS shows CategoryPage3 for anons even if they have a cookie set'
		];
		yield [
			false,
			true,
			false,
			null,
			null,
			MockObject::class,
			'Non-category NS is ignored by the hook'
		];
		yield [
			true,
			false,
			false,
			'mediawiki',
			'category-exhibition',
			CategoryPageMediawiki::class,
			'Users can override layout to vanilla MediaWiki using a cookie'
		];
		yield [
			true,
			false,
			false,
			'category-exhibition',
			'mediawiki',
			CategoryExhibitionPage::class,
			'Users can override layout to CategoryExhibition using a cookie'
		];
		yield [
			true,
			false,
			true,
			'category-exhibition',
			null,
			CategoryPage3::class,
			'Users can\'t force CategoryExhibition using a cookie if it\'s disabled for the title'
		];
		yield [
			true,
			false,
			false,
			'category-page3',
			'mediawiki',
			CategoryPage3::class,
			'Users can override layout to CategoryPage3 using a cookie'
		];
		yield [
			true,
			false,
			false,
			'corrupted-cookie',
			'mediawiki',
			CategoryPageMediawiki::class,
			'Users can override layout to vanilla MediaWiki by using a preference'
		];
		yield [
			true,
			false,
			false,
			null,
			'category-exhibition',
			CategoryExhibitionPage::class,
			'Users can override layout to CategoryExhibition by using a preference'
		];
		yield [
			true,
			false,
			true,
			null,
			'category-exhibition',
			CategoryPage3::class,
			'Users can\'t force CategoryExhibition using a preference if it\'s disabled for the title'
		];
		yield [
			true,
			false,
			false,
			null,
			'category-page3',
			CategoryPage3::class,
			'Display CategoryPage3 if it\'s set in preferences'
		];
	}

	/**
	 * @dataProvider onLinkerMakeExternalLinkDataProvider
	 * @param string $url
	 * @param int $cityId
	 * @param string $expectedLink
	 */
	public function testOnLinkerMakeExternalLink( string $url, $cityId, string $expectedLink ) {
		// Mock
		$languageMock = $this->getMockBuilder( 'Language' )
			->disableOriginalConstructor()
			->setMethods( [ 'getNsText' ] )
			->getMock();
		$languageMock->expects( $this->atMost( 1 ) )
			->method( 'getNsText' )
			->willReturn( 'Category' );

		$this->mockStaticMethodWithCallBack(
			'\WikiFactory',
			'UrlToID',
			function ( $host ) {
				$hostToCityId = [
					'first.wikia.com' => 1,
					'second.fandom.com' => 2
				];
				return $hostToCityId[ $host ];
			} );

		$this->mockGlobalVariable( 'wgContLang', $languageMock );
		$this->mockGlobalVariable( 'wgCityId', $cityId );
		$this->mockGlobalVariable( 'wgFandomBaseDomain', 'fandom.com' );
		$this->mockGlobalVariable( 'wgWikiaBaseDomain', 'wikia.com' );


		// Run
		$link = static::ORIGINAL_LINK;
		CategoryPage3Hooks::onLinkerMakeExternalLink( $url, '', $link, [] );

		// Assert
		$this->assertEquals( $expectedLink, $link );
	}

	public function onLinkerMakeExternalLinkDataProvider(): Generator {
		yield [
			'http://first.wikia.com/wiki/Category:A?from=B',
			1,
			'<a rel="nofollow" data-uncrawlable-url="aHR0cDovL2ZpcnN0Lndpa2lhLmNvbS93aWtpL0NhdGVnb3J5OkE/ZnJvbT1C"></a>'
		];
		yield [
			'https://second.fandom.com/wiki/Category:A?from=B&action=raw',
			2,
			'<a rel="nofollow" data-uncrawlable-url="aHR0cHM6Ly9zZWNvbmQuZmFuZG9tLmNvbS93aWtpL0NhdGVnb3J5OkE/ZnJvbT1CJmFjdGlvbj1yYXc="></a>'
		];
		yield [
			'http://first.wikia.com/wiki/Category:A?action=raw',
			1,
			static::ORIGINAL_LINK
		];
		yield [
			'http://first.wikia.com/wiki/Category:A?from=B',
			2,
			static::ORIGINAL_LINK
		];
		yield [
			'https://google.com/wiki/Category:A',
			1,
			static::ORIGINAL_LINK
		];
	}
}
