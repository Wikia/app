<?php

class SitemapHooksTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../SitemapXml.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider canonicalRedirectProvider
	 */
	public function testCanonicalRedirect( $currentRequestUri, $targetUrl, $shouldAllowRedirect ) {
		$outputMock = $this->getMock( 'OutputPage', [ 'cancelRedirect' ] );
		$responseMock = $this->getMock( 'WebResponse', [ 'header' ] );
		$requestMock = $this->getMock( 'WebRequest', [ 'response' ] );
		$titleMock = $this->getMock( 'Title', [ 'isSpecial', 'getFullURL' ] );

		$requestMock->expects( $this->any() )
			->method( 'response' )
			->will( $this->returnValue( $responseMock ) );

		$titleMock->expects( $this->any() )
			->method( 'isSpecial' )
			->will( $this->returnValue( true ) );

		$titleMock->expects( $this->any() )
			->method( 'getFullURL' )
			->will( $this->returnValue( $targetUrl ) );

		$this->mockStaticMethod( 'WebRequest', 'detectProtocol', parse_url( $currentRequestUri, PHP_URL_SCHEME ) );
		$this->mockStaticMethod( 'WikiFactoryLoader', 'getCurrentRequestUri', $currentRequestUri );

		$result = SitemapHooks::onTestCanonicalRedirect( $requestMock, $titleMock, $outputMock );

		$this->assertSame( $result, $shouldAllowRedirect );
	}

	public function canonicalRedirectProvider() {
		return [
			[
				'http://starwars.wikia.com/sitemap-newsitemapxml-index.xml',
				'https://starwars.fandom.com/sitemap-newsitemapxml-index.xml',
				false
			],
			[
				'https://starwars.wikia.com/sitemap-newsitemapxml-index.xml',
				'https://starwars.fandom.com/sitemap-newsitemapxml-index.xml',
				true
			],
			[
				'http://starwars.fandom.com/sitemap-newsitemapxml-index.xml',
				'https://starwars.fandom.com/sitemap-newsitemapxml-index.xml',
				true
			],
			[
				'http://starwars.wikia.com/sitemap-newsitemapxml-index.xml',
				'https://starwars.wikia.com/sitemap-newsitemapxml-index.xml',
				true
			],
			[
				'http://wookieepedia.wikia.com/sitemap-newsitemapxml-index.xml',
				'https://starwars.fandom.com/sitemap-newsitemapxml-index.xml',
				true
			],
			[
				'https://wookieepedia.wikia.com/sitemap-newsitemapxml-index.xml',
				'https://starwars.fandom.com/sitemap-newsitemapxml-index.xml',
				true
			],
			[
				'http://ja.starwars.wikia.com/sitemap-newsitemapxml-index.xml',
				'https://starwars.fandom.com/sitemap-newsitemapxml-index.xml',
				true
			],
			[
				'http://ja.starwars.wikia.com/sitemap-newsitemapxml-index.xml',
				'https://starwars.fandom.com/ja/sitemap-newsitemapxml-index.xml',
				false
			],
			[
				'http://ja.wookieepedia.wikia.com/sitemap-newsitemapxml-index.xml',
				'https://starwars.fandom.com/ja/sitemap-newsitemapxml-index.xml',
				true
			],
			[
				'http://ja.starwars.fandom.com/sitemap-newsitemapxml-index.xml',
				'https://starwars.fandom.com/ja/sitemap-newsitemapxml-index.xml',
				true
			],
			[
				'http://ja.starwars.wikia.com/sitemap-newsitemapxml-index.xml',
				'https://starwars.wikia.com/ja/sitemap-newsitemapxml-index.xml',
				true
			],
		];
	}
}
