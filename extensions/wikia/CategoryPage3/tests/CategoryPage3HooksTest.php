<?php

class CategoryPage3HooksTest extends WikiaBaseTest {
	const ORIGINAL_LINK = 'original-link';

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../CategoryPage3Hooks.class.php';
		parent::setUp();
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
			->setMethods( [ 'getNsText' ] )->getMock();
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
				return $hostToCityId[$host];
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

	public function onLinkerMakeExternalLinkDataProvider() {
		return [
			[
				'http://first.wikia.com/wiki/Category:A?from=B',
				1,
				'<a href="#" rel="nofollow" data-category-url-encoded="aHR0cDovL2ZpcnN0Lndpa2lhLmNvbS93aWtpL0NhdGVnb3J5OkE/ZnJvbT1C"></a>'
			],
			[
				'https://second.fandom.com/wiki/Category:A?from=B&action=raw',
				2,
				'<a href="#" rel="nofollow" data-category-url-encoded="aHR0cHM6Ly9zZWNvbmQuZmFuZG9tLmNvbS93aWtpL0NhdGVnb3J5OkE/ZnJvbT1CJmFjdGlvbj1yYXc="></a>'
			],
			[
				'http://first.wikia.com/wiki/Category:A?action=raw',
				1,
				static::ORIGINAL_LINK
			],
			[
				'http://first.wikia.com/wiki/Category:A?from=B',
				2,
				static::ORIGINAL_LINK
			],
			[
				'https://google.com/wiki/Category:A',
				1,
				static::ORIGINAL_LINK
			]
		];
	}
}
