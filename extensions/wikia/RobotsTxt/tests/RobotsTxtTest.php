<?php

class RobotsTxtTest extends WikiaBaseTest {

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
	}

	/**
	 * Test allowSpecialPage in non-English language
	 *
	 * @covers RobotsTxt::allowSpecialPage
	 */
	public function testAllowSpecialPageInternational() {
		$this->mockGlobalVariable( 'wgContLang', Language::factory('de') );
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
	}

	/**
	 * Test disallowPath and limited URI encoding
	 *
	 * @covers RobotsTxt::disallowPath
	 */
	public function testDisallowPath() {
		$robots = new RobotsTxt();
		$robots->disallowPath( '/some-path' );
		$robots->disallowPath( '/some-path:ąść' );
		$robots->disallowPath( '/some-path:サイトマップ' );
		$robots->disallowPath( '/*/*%$' );
		$this->assertEquals( [
			'User-agent: *',
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
	}

	/**
	 * Test disallowNamespace in non-English language
	 *
	 * @covers RobotsTxt::disallowNamespace
	 */
	public function testDisallowNamespaceInternational() {
		$this->mockGlobalVariable( 'wgContLang', Language::factory('de') );
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
	}
}
