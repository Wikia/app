<?php

use Wikia\RobotsTxt\WikiaRobots;

class WikiaRobotsTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/RobotsTxt/RobotsTxt.setup.php";
		parent::setUp();
	}

	/**
	 * Get mock for Wikia\RobotsTxt\PathBuilder
	 *
	 * Wikia\RobotsTxt\PathBuilder has a separate set of tests, so here we're injecting a mock here instead
	 *
	 * The way it works it returns one-item array for each of the mocked methods contructing
	 * the path like that:
	 *
	 *  * /path/for/ns/NS_ID for buildPathsForNamespace
	 *  * /path/for/page/PAGENAME for buildPathsForSpecialPage
	 *  * /path/for/param/PARAM for buildPathsForParam
	 *
	 * @return Wikia\RobotsTxt\PathBuilder
	 */
	private function getPathBuilderMock() {
		$pathBuilderMock = $this->getMockBuilder( 'Wikia\RobotsTxt\PathBuilder' )->getMock();
		$pathBuilderMock->expects( $this->any() )
			->method( 'buildPathsForNamespace' )
			->willReturnCallback( function ( $in ) {
				return [ '/path/for/ns/' . $in ];
			} );
		$pathBuilderMock->expects( $this->any() )
			->method( 'buildPathsForSpecialPage' )
			->willReturnCallback( function ( $page ) {
				return [ '/path/for/page/' . $page ];
			} );
		$pathBuilderMock->expects( $this->any() )
			->method( 'buildPathsForParam' )
			->willReturnCallback( function ( $param ) {
				return [ '/path/for/param/' . $param ];
			} );
		return $pathBuilderMock;
	}

	/**
	 * Get a mock for RobotsTxt
	 *
	 * You can inspect its members
	 *
	 * spiedAllowedPaths -- array of params passed to addAllowedPaths: one item per method call
	 * spiedDisallowedPaths -- array of params passed to addDisallowedPaths: one item per method call
	 * spiedSitemap -- array of params passed to setSitemap: one item per method call
	 * spiedBlockedRobots -- array of params passed to addBlockedRobots: one item per method call
	 *
	 * @return RobotsTxtMock
	 */
	private function getRobotsTxtMock() {
		return new RobotsTxtMock();
	}

	/**
	 * Get Wikia RobotsTxt
	 * @return RobotsTxt
	 */
	private function getWikiaRobotsTxt() {
		$robotsTxtMock = $this->getRobotsTxtMock();
		$pathBuilderMock = $this->getPathBuilderMock();

		$wikiaRobots = new WikiaRobots( $pathBuilderMock );
		$robotsTxt = $wikiaRobots->configureRobotsBuilder( $robotsTxtMock );

		return $robotsTxt;
	}

	private function isNamespaceDisallowed( RobotsTxtMock $robotsTxtSpy, $ns ) {
		$path = '/path/for/ns/' . $ns;
		$isAllowed = false;
		$isDisallowed = false;
		$spiedWildcardRobot = $robotsTxtSpy->spiedRobots[ '*' ];
		foreach ( $spiedWildcardRobot->spiedAllowed as $paths ) {
			if ( in_array( $path, $paths ) ) {
				$isAllowed = true;
			}
		}
		foreach ( $spiedWildcardRobot->spiedDisallowed as $paths ) {
			if ( in_array( $path, $paths ) ) {
				$isDisallowed = true;
			}
		}
		return $isDisallowed && !$isAllowed;
	}

	private function isSpecialPageAllowed( RobotsTxtMock $robotsTxtSpy, $page ) {
		$path = '/path/for/page/' . $page;
		$isAllowed = false;
		$isDisallowed = false;
		$spiedWildcardRobot = $robotsTxtSpy->spiedRobots[ '*' ];
		foreach ( $spiedWildcardRobot->spiedAllowed as $paths ) {
			if ( in_array( $path, $paths ) ) {
				$isAllowed = true;
			}
		}
		foreach ( $spiedWildcardRobot->spiedDisallowed as $paths ) {
			if ( in_array( $path, $paths ) ) {
				$isDisallowed = true;
			}
		}
		return $isAllowed && !$isDisallowed;
	}

	/**
	 * Test Wikia\RobotsTxt\WikiaRobots builds a "Disallow: /" robots.txt on dev environment
	 *
	 * @dataProvider dataProviderNonProductionEnvironment
	 */
	public function testNonProductionEnvironment( $env ) {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', $env );
		$this->mockGlobalVariable( 'wgRobotsTxtBlockedWiki', false );

		$robotsTxtMock = $this->getWikiaRobotsTxt();
		$spiedWildcardRobot = $robotsTxtMock->spiedRobots[ '*' ];

		$this->assertEquals( $spiedWildcardRobot->spiedDisallowed, [ [ '/' ] ] );
		$this->assertEquals( $spiedWildcardRobot->spiedAllowed, [] );
		$this->assertEquals( $spiedWildcardRobot->getUserAgent(), '*' );
		$this->assertEquals( $robotsTxtMock->spiedSitemap, [] );
	}

	public function dataProviderNonProductionEnvironment() {
		return [
			[ WIKIA_ENV_PREVIEW ],
			[ WIKIA_ENV_SANDBOX ],
			[ WIKIA_ENV_VERIFY ],
			[ WIKIA_ENV_STABLE ],
		];
	}

	/**
	 * Test Wikia\RobotsTxt\WikiaRobots sets the proper sitemap based on wgServer,
	 * wgEnableSpecialSitemapExt, wgEnableSitemapXmlExt and wgSitemapXmlExposeInRobots
	 *
	 * @dataProvider dataProviderSitemap
	 */
	public function testSitemap( $wgEnableSpecialSitemapExt, $wgEnableSitemapXmlExt, $wgSitemapXmlExposeInRobots, $sitemapUrls ) {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtBlockedWiki', false );
		$this->mockGlobalVariable( 'wgServer', 'http://server' );
		$this->mockGlobalVariable( 'wgEnableSpecialSitemapExt', $wgEnableSpecialSitemapExt );
		$this->mockGlobalVariable( 'wgEnableSitemapXmlExt', $wgEnableSitemapXmlExt );
		$this->mockGlobalVariable( 'wgSitemapXmlExposeInRobots', $wgSitemapXmlExposeInRobots );

		$robotsTxtMock = $this->getWikiaRobotsTxt();

		$this->assertEquals( $robotsTxtMock->spiedSitemap, $sitemapUrls );
	}

	public function dataProviderSitemap() {
		return [
			# $wgEnableSpecialSitemapExt, $wgEnableSitemapXmlExt, $wgSitemapXmlExposeInRobots, $sitemapUrls
			[ false, false, false, [] ],
			[ false, false, true, [] ],
			[ false, true, false, [] ],
			[ false, true, true, [ 'http://server/sitemap-newsitemapxml-index.xml' ] ],
			[ true, false, false, [ 'http://server/sitemap-index.xml' ] ],
			[ true, false, true, [ 'http://server/sitemap-index.xml' ] ],
			[ true, true, false, [ 'http://server/sitemap-index.xml' ] ],
			[ true, true, true, [ 'http://server/sitemap-newsitemapxml-index.xml' ] ],
		];
	}

	public function testDisallowedNamespaces() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtBlockedWiki', false );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', null );

		$robotsTxtMock = $this->getWikiaRobotsTxt();

		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_SPECIAL ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_TEMPLATE ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_TEMPLATE_TALK ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_USER_TALK ) );
		$this->assertFalse( $this->isNamespaceDisallowed( $robotsTxtMock, NS_USER ) );
		$this->assertFalse( $this->isNamespaceDisallowed( $robotsTxtMock, NS_HELP ) );
	}

	public function testCustomRobotsRulesSingleNamespace() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtBlockedWiki', false );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', [ 'disallowNamespace' => NS_HELP ] );

		$robotsTxtMock = $this->getWikiaRobotsTxt();

		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_SPECIAL ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_TEMPLATE ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_TEMPLATE_TALK ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_USER_TALK ) );
		$this->assertFalse( $this->isNamespaceDisallowed( $robotsTxtMock, NS_USER ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_HELP ) );
	}

	public function testCustomRobotsRulesMultipleNamespaces() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtBlockedWiki', false );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', [ 'disallowNamespace' => [ NS_USER, NS_HELP ] ] );

		$robotsTxtMock = $this->getWikiaRobotsTxt();

		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_SPECIAL ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_TEMPLATE ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_TEMPLATE_TALK ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_USER_TALK ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_USER ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_HELP ) );
	}

	public function testAllowedSpecialPages() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtBlockedWiki', false );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', null );

		$robotsTxtMock = $this->getWikiaRobotsTxt();

		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Forum' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Sitemap' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Videos' ) );
		$this->assertFalse( $this->isSpecialPageAllowed( $robotsTxtMock, 'MyPage1' ) );
		$this->assertFalse( $this->isSpecialPageAllowed( $robotsTxtMock, 'MyPage2' ) );
	}

	public function testCustomRobotsRulesSingleSpecialPage() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtBlockedWiki', false );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', [ 'allowSpecialPage' => 'MyPage1' ] );

		$robotsTxtMock = $this->getWikiaRobotsTxt();

		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Forum' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Sitemap' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Videos' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'MyPage1' ) );
		$this->assertFalse( $this->isSpecialPageAllowed( $robotsTxtMock, 'MyPage2' ) );
	}

	public function testCustomRobotsRulesMultipleSpecialPages() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtBlockedWiki', false );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', [ 'allowSpecialPage' => [ 'MyPage1', 'MyPage2' ] ] );

		$robotsTxtMock = $this->getWikiaRobotsTxt();

		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Forum' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Sitemap' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Videos' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'MyPage1' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'MyPage2' ) );
	}

	/**
	 * Test building robots.txt for blocked wiki
	 *
	 * @dataProvider dataProviderBlockedWiki
	 */
	public function testBlockedWiki( $mockWgWikiaEnvironment, $mockWgRobotsTxtBlockedWiki ) {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', $mockWgWikiaEnvironment );
		$this->mockGlobalVariable( 'wgRobotsTxtBlockedWiki', $mockWgRobotsTxtBlockedWiki );

		$robotsTxtMock = $this->getWikiaRobotsTxt();
		$spiedWildcardRobot = $robotsTxtMock->spiedRobots[ '*' ];

		$this->assertEquals( $spiedWildcardRobot->spiedDisallowed, [ [ '/' ] ] );
		$this->assertEquals( $spiedWildcardRobot->spiedAllowed, [] );
		$this->assertEquals( $spiedWildcardRobot->getUserAgent(), '*' );
		$this->assertEquals( $robotsTxtMock->spiedSitemap, [] );
	}

	public function dataProviderBlockedWiki() {
		return [
			[ WIKIA_ENV_DEV, true ],
			[ WIKIA_ENV_DEV, false ],
			[ WIKIA_ENV_PROD, true ],
		];
	}

}
