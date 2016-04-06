<?php

class RobotsTxtTest extends WikiaBaseTest {

	const DEFAULT_HEADERS = [
		'Content-Type: text/plain',
		'Cache-Control: s-maxage=86400',
		'X-Pass-Cache-Control: public, max-age=86400',
	];
	const EXPERIMENTAL_HEADERS = [
		'Content-Type: text/plain',
		'Cache-Control: s-maxage=3600',
		'X-Pass-Cache-Control: public, max-age=3600',
	];

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/RobotsTxt/RobotsTxt.setup.php";
		parent::setUp();
	}

	/**
	 * Test empty robots.txt
	 */
	public function testEmpty() {
		$robots = new RobotsTxt();

		$this->assertEquals( [], $robots->getContents() );
		$this->assertEquals( self::DEFAULT_HEADERS, $robots->getHeaders() );
	}

	/**
	 * Test allowSpecialPage
	 *
	 * @covers RobotsTxt::allowSpecialPage
	 */
	public function testAllowSpecialPage() {
		$robots = new RobotsTxt();
		$robots->allowSpecialPage( 'Randompage' );

		$this->assertEquals( [
			'User-agent: *',
			'Allow: /wiki/Special:Random',
			'Allow: /wiki/Special:RandomPage',
			'',
		], $robots->getContents() );
		$this->assertEquals( self::DEFAULT_HEADERS, $robots->getHeaders() );
	}

	/**
	 * Test allowSpecialPage in non-English language
	 *
	 * @covers RobotsTxt::allowSpecialPage
	 */
	public function testAllowSpecialPageInternational() {
		$this->mockGlobalVariable( 'wgContLang', Language::factory( 'de' ) );
		$robots = new RobotsTxt();
		$robots->allowSpecialPage( 'Randompage' );

		$this->assertEquals( [
			'User-agent: *',
			'Allow: /wiki/Spezial:Zuf%C3%A4llige_Seite',
			'Allow: /wiki/Spezial:Random',
			'Allow: /wiki/Spezial:RandomPage',
			'Allow: /wiki/Special:Zuf%C3%A4llige_Seite',
			'Allow: /wiki/Special:Random',
			'Allow: /wiki/Special:RandomPage',
			'',
		], $robots->getContents() );
		$this->assertEquals( self::DEFAULT_HEADERS, $robots->getHeaders() );
	}

	/**
	 * Test blockRobot
	 *
	 * @covers RobotsTxt::testBlockRobot
	 */
	public function testBlockRobot() {
		$robots = new RobotsTxt();
		$robots->blockRobot( 'my-fancy-robot' );
		$robots->blockRobot( 'your-nasty-robot' );

		$this->assertEquals( [
			'User-agent: my-fancy-robot',
			'Disallow: /',
			'',
			'User-agent: your-nasty-robot',
			'Disallow: /',
			'',
		], $robots->getContents() );
		$this->assertEquals( self::DEFAULT_HEADERS, $robots->getHeaders() );
	}

	/**
	 * Test disallowParam
	 *
	 * @covers RobotsTxt::disallowParam
	 */
	public function testDisallowParam() {
		$robots = new RobotsTxt();
		$robots->disallowParam( 'someparam' );

		$this->assertEquals( [
			'User-agent: *',
			'Disallow: /*?*someparam=',
			'Noindex: /*?*someparam=',
			'',
		], $robots->getContents() );
		$this->assertEquals( self::DEFAULT_HEADERS, $robots->getHeaders() );
	}

	/**
	 * Test disallowPath and allowPath, and limited URI encoding
	 *
	 * @covers RobotsTxt::disallowPath
	 * @covers RobotsTxt::allowPath
	 */
	public function testDisallowAndAllowPath() {
		$robots = new RobotsTxt();
		$robots->disallowPath( '/some-path' );
		$robots->disallowPath( '/some-path:ąść' );
		$robots->disallowPath( '/some-path:サイトマップ' );
		$robots->disallowPath( '/*/*%$' );
		$robots->allowPath( '/other-path' );
		$robots->allowPath( '/other-path:ąść' );
		$robots->allowPath( '/other-path:サイトマップ' );
		$robots->allowPath( '/*/*^$' );

		$this->assertEquals( [
			'User-agent: *',
			'Allow: /other-path',
			'Allow: /other-path:%C4%85%C5%9B%C4%87',
			'Allow: /other-path:%E3%82%B5%E3%82%A4%E3%83%88%E3%83%9E%E3%83%83%E3%83%97',
			'Allow: /*/*%5E$',
			'Disallow: /some-path',
			'Disallow: /some-path:%C4%85%C5%9B%C4%87',
			'Disallow: /some-path:%E3%82%B5%E3%82%A4%E3%83%88%E3%83%9E%E3%83%83%E3%83%97',
			'Disallow: /*/*%25$',
			'Noindex: /some-path',
			'Noindex: /some-path:%C4%85%C5%9B%C4%87',
			'Noindex: /some-path:%E3%82%B5%E3%82%A4%E3%83%88%E3%83%9E%E3%83%83%E3%83%97',
			'Noindex: /*/*%25$',
			'',
		], $robots->getContents() );
		$this->assertEquals( self::DEFAULT_HEADERS, $robots->getHeaders() );
	}

	/**
	 * Test disallowNamespace
	 *
	 * @covers RobotsTxt::disallowNamespace
	 */
	public function testDisallowNamespace() {
		$robots = new RobotsTxt();
		$robots->disallowNamespace( NS_FILE );

		$this->assertEquals( [
			'User-agent: *',
			'Disallow: /wiki/File:',
			'Disallow: /*?*title=File:',
			'Disallow: /index.php/File:',
			'Noindex: /wiki/File:',
			'Noindex: /*?*title=File:',
			'Noindex: /index.php/File:',
			'',
		], $robots->getContents() );
		$this->assertEquals( self::DEFAULT_HEADERS, $robots->getHeaders() );
	}

	/**
	 * Test disallowNamespace in non-English language
	 *
	 * @covers RobotsTxt::disallowNamespace
	 */
	public function testDisallowNamespaceInternational() {
		$this->mockGlobalVariable( 'wgContLang', Language::factory( 'de' ) );
		$robots = new RobotsTxt();
		$robots->disallowNamespace( NS_FILE );

		$this->assertEquals( [
			'User-agent: *',
			'Disallow: /wiki/Datei:',
			'Disallow: /*?*title=Datei:',
			'Disallow: /index.php/Datei:',
			'Disallow: /wiki/File:',
			'Disallow: /*?*title=File:',
			'Disallow: /index.php/File:',
			'Noindex: /wiki/Datei:',
			'Noindex: /*?*title=Datei:',
			'Noindex: /index.php/Datei:',
			'Noindex: /wiki/File:',
			'Noindex: /*?*title=File:',
			'Noindex: /index.php/File:',
			'',
		], $robots->getContents() );
		$this->assertEquals( self::DEFAULT_HEADERS, $robots->getHeaders() );
	}

	/**
	 * Test setSitemap
	 *
	 * @covers RobotsTxt::setSitemap
	 */
	public function testSetSitemap() {
		$robots = new RobotsTxt();
		$robots->setSitemap( 'http://www.my-site.com/sitemap.xml' );

		$this->assertEquals( [
			'Sitemap: http://www.my-site.com/sitemap.xml',
		], $robots->getContents() );
		$this->assertEquals( self::DEFAULT_HEADERS, $robots->getHeaders() );
	}

	/**
	 * Test getContents produces the output in the right order
	 *
	 * @covers RobotsTxt::getContents
	 */
	public function testGetContentsOrder() {
		$robots = new RobotsTxt();
		$robots->disallowPath( '/abc' );
		$robots->blockRobot( 'robot-1' );
		$robots->allowSpecialPage( 'Randompage' );
		$robots->setSitemap( 'http://www.my-site.com/sitemap.xml' );

		$this->assertEquals( [
			'User-agent: robot-1',
			'Disallow: /',
			'',
			'User-agent: *',
			'Allow: /wiki/Special:Random',
			'Allow: /wiki/Special:RandomPage',
			'Disallow: /abc',
			'Noindex: /abc',
			'',
			'Sitemap: http://www.my-site.com/sitemap.xml',
		], $robots->getContents() );
		$this->assertEquals( self::DEFAULT_HEADERS, $robots->getHeaders() );
	}

	/**
	 * Test getContents produces the output taken from setExperimentalAllowDissalowSection and
	 * test the cache is set to one hour
	 *
	 * @covers RobotsTxt::setExperimentalAllowDisallowSection
	 */
	public function testSetExperimentalAllowDisallowSection() {
		$robots = new RobotsTxt();
		$robots->setSitemap( 'http://www.my-site.com/sitemap.xml' );
		$robots->setExperimentalAllowDisallowSection( "Test: Test\nAbba: Abba" );

		$this->assertEquals( [
			'Test: Test',
			'Abba: Abba',
			'',
			'Sitemap: http://www.my-site.com/sitemap.xml',
		], $robots->getContents() );
		$this->assertEquals( self::EXPERIMENTAL_HEADERS, $robots->getHeaders() );
	}

	/**
	 * Test setCustomRules
	 * @dataProvider setCustomRulesDataProvider
	 * @covers RobotsTxt::setCustomRules
	 *
	 * @param $mockWgRobotsTxtCustomRules
	 * @param $expResult
	 */
	public function testSetCustomRules( $mockWgRobotsTxtCustomRules, $lang, $expResult ) {
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', $mockWgRobotsTxtCustomRules );
		$this->mockGlobalVariable( 'wgContLang', Language::factory( $lang ) );

		$robots = new RobotsTxt();
		$robots->setCustomRules();
		$result = $robots->getContents();
		$this->assertEquals( $expResult, $result );
	}

	public function setCustomRulesDataProvider()
	{
		$expResult1 = [];
		$mockWgRobotsTxtCustomRules11 = [];
		$mockWgRobotsTxtCustomRules12 = '';

		$expResult2En = [
			'User-agent: *',
			'Disallow: /wiki/Help:',
			'Disallow: /*?*title=Help:',
			'Disallow: /index.php/Help:',
			'Noindex: /wiki/Help:',
			'Noindex: /*?*title=Help:',
			'Noindex: /index.php/Help:',
			'',
		];
		$expResult2De = [
			'User-agent: *',
			'Disallow: /wiki/Hilfe:',
			'Disallow: /*?*title=Hilfe:',
			'Disallow: /index.php/Hilfe:',
			'Disallow: /wiki/Help:',
			'Disallow: /*?*title=Help:',
			'Disallow: /index.php/Help:',
			'Noindex: /wiki/Hilfe:',
			'Noindex: /*?*title=Hilfe:',
			'Noindex: /index.php/Hilfe:',
			'Noindex: /wiki/Help:',
			'Noindex: /*?*title=Help:',
			'Noindex: /index.php/Help:',
			'',
		];
		$mockWgRobotsTxtCustomRules21 = [ 'disallowNamespace' => NS_HELP ];
		$mockWgRobotsTxtCustomRules22 = [ 'disallowNamespace' => [ NS_HELP ] ];

		$expResult3 = [
			'User-agent: *',
			'Disallow: /wiki/Help:',
			'Disallow: /*?*title=Help:',
			'Disallow: /index.php/Help:',
			'Disallow: /wiki/User:',
			'Disallow: /*?*title=User:',
			'Disallow: /index.php/User:',
			'Noindex: /wiki/Help:',
			'Noindex: /*?*title=Help:',
			'Noindex: /index.php/Help:',
			'Noindex: /wiki/User:',
			'Noindex: /*?*title=User:',
			'Noindex: /index.php/User:',
			'',
		];
		$mockWgRobotsTxtCustomRules3 = [ 'disallowNamespace' => [ NS_HELP, NS_USER ] ];

		$expResult4En = [
			'User-agent: *',
			'Allow: /wiki/Special:Videos',
			'Allow: /wiki/Special:Video',
			'',
		];
		$expResult4De = [
			'User-agent: *',
			'Allow: /wiki/Spezial:Videos',
			'Allow: /wiki/Spezial:Video',
			'Allow: /wiki/Special:Videos',
			'Allow: /wiki/Special:Video',
			'',
		];
		$mockWgRobotsTxtCustomRules41 = [ 'allowSpecialPage' => 'Videos' ];
		$mockWgRobotsTxtCustomRules42 = [ 'allowSpecialPage' => [ 'Videos' ] ];

		$expResult5 = [
			'User-agent: *',
			'Allow: /wiki/Special:Forum',
			'Allow: /wiki/Special:Forums',
			'Allow: /wiki/Special:Videos',
			'Allow: /wiki/Special:Video',
			'Disallow: /wiki/Help:',
			'Disallow: /*?*title=Help:',
			'Disallow: /index.php/Help:',
			'Noindex: /wiki/Help:',
			'Noindex: /*?*title=Help:',
			'Noindex: /index.php/Help:',
			'',
		];
		$mockWgRobotsTxtCustomRules5 = [
			'allowSpecialPage' => [ 'Forum', 'Videos' ],
			'disallowNamespace' => [ NS_HELP ],
		];

		return [
			// No custom rules
			[ $mockWgRobotsTxtCustomRules11, 'en', $expResult1 ],
			[ $mockWgRobotsTxtCustomRules12, 'en', $expResult1 ],
			// disallow namespace
			[ $mockWgRobotsTxtCustomRules21, 'en', $expResult2En ],
			[ $mockWgRobotsTxtCustomRules22, 'en', $expResult2En ],
			[ $mockWgRobotsTxtCustomRules22, 'de', $expResult2De ],
			[ $mockWgRobotsTxtCustomRules3, 'en', $expResult3 ],
			// allow special pages
			[ $mockWgRobotsTxtCustomRules41, 'en', $expResult4En ],
			[ $mockWgRobotsTxtCustomRules42, 'en', $expResult4En ],
			[ $mockWgRobotsTxtCustomRules42, 'de', $expResult4De ],
			// disallow namespace + allow special pages
			[ $mockWgRobotsTxtCustomRules5, 'en', $expResult5 ],
		];
	}

}
