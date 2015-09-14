<?php

class RobotsTest extends WikiaBaseTest {

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
			'',
		], $robots->getContents() );
	}

	/**
	 * Test disallowSpecialPages
	 *
	 * @covers RobotsTxt::testDisallowSpecialPages
	 */
	public function testDisallowSpecialPages() {
		$robots = new RobotsTxt();
		$robots->disallowSpecialPages();
		$this->assertEquals( [
			'User-agent: *',
			'Disallow: /wiki/Special:',
			'Disallow: /*?*title=Special:',
			'Disallow: /index.php/Special:',
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
			'',
			'Sitemap: http://www.my-site.com/sitemap.xml',
		], $robots->getContents() );
	}
}
