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

	private function isNamespaceDisallowed( RobotsTxtMock $robotsTxtSpy, $ns ) {
		$path = '/path/for/ns/' . $ns;
		$isAllowed = false;
		$isDisallowed = false;
		foreach ( $robotsTxtSpy->spiedAllowedPaths as $paths ) {
			if ( in_array( $path, $paths ) ) {
				$isAllowed = true;
			}
		}
		foreach ( $robotsTxtSpy->spiedDisallowedPaths as $paths ) {
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
		foreach ( $robotsTxtSpy->spiedAllowedPaths as $paths ) {
			if ( in_array( $path, $paths ) ) {
				$isAllowed = true;
			}
		}
		foreach ( $robotsTxtSpy->spiedDisallowedPaths as $paths ) {
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

		$robotsTxtMock = $this->getRobotsTxtMock();
		$pathBuilderMock = $this->getPathBuilderMock();

		$wikiaRobots = new WikiaRobots( $pathBuilderMock );
		$wikiaRobots->configureRobotsBuilder( $robotsTxtMock );

		$this->assertEquals( $robotsTxtMock->spiedDisallowedPaths, [ [ '/' ] ] );
		$this->assertEquals( $robotsTxtMock->spiedAllowedPaths, [] );
		$this->assertEquals( $robotsTxtMock->spiedBlockedRobots, [] );
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
	 * Test Wikia\RobotsTxt\WikiaRobots sets the proper sitemap based on wgServer
	 */
	public function testSitemapEnabled() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgServer', 'http://server' );
		$this->mockGlobalVariable( 'wgEnableSpecialSitemapExt', true );

		$robotsTxtMock = $this->getRobotsTxtMock();
		$pathBuilderMock = $this->getPathBuilderMock();

		$wikiaRobots = new WikiaRobots( $pathBuilderMock );
		$wikiaRobots->configureRobotsBuilder( $robotsTxtMock );

		$this->assertEquals( $robotsTxtMock->spiedSitemap, [ 'http://server/sitemap-index.xml' ] );
	}

	/**
	 * Test Wikia\RobotsTxt\WikiaRobots doesn't set the sitemap if wgEnableSpecialSitemapExt is false
	 */
	public function testSitemapDisabled() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgServer', 'http://server' );
		$this->mockGlobalVariable( 'wgEnableSpecialSitemapExt', false );

		$robotsTxtMock = $this->getRobotsTxtMock();
		$pathBuilderMock = $this->getPathBuilderMock();

		$wikiaRobots = new WikiaRobots( $pathBuilderMock );

		$wikiaRobots->configureRobotsBuilder( $robotsTxtMock );
		$this->assertEquals( $robotsTxtMock->spiedSitemap, [] );
	}

	public function testDisallowedNamespaces() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', null );

		$robotsTxtMock = $this->getRobotsTxtMock();
		$pathBuilderMock = $this->getPathBuilderMock();

		$wikiaRobots = new WikiaRobots( $pathBuilderMock );
		$wikiaRobots->configureRobotsBuilder( $robotsTxtMock );

		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_SPECIAL ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_TEMPLATE ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_TEMPLATE_TALK ) );
		$this->assertFalse( $this->isNamespaceDisallowed( $robotsTxtMock, NS_USER ) );
		$this->assertFalse( $this->isNamespaceDisallowed( $robotsTxtMock, NS_HELP ) );
	}

	public function testCustomRobotsRulesSingleNamespace() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', [ 'disallowNamespace' => NS_HELP ] );

		$robotsTxtMock = $this->getRobotsTxtMock();
		$pathBuilderMock = $this->getPathBuilderMock();

		$wikiaRobots = new WikiaRobots( $pathBuilderMock );
		$wikiaRobots->configureRobotsBuilder( $robotsTxtMock );

		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_SPECIAL ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_TEMPLATE ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_TEMPLATE_TALK ) );
		$this->assertFalse( $this->isNamespaceDisallowed( $robotsTxtMock, NS_USER ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_HELP ) );
	}

	public function testCustomRobotsRulesMultipleNamespaces() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', [ 'disallowNamespace' => [ NS_USER, NS_HELP ] ] );

		$pathBuilderMock = $this->getPathBuilderMock();
		$robotsTxtMock = $this->getRobotsTxtMock();

		$wikiaRobots = new WikiaRobots( $pathBuilderMock );
		$wikiaRobots->configureRobotsBuilder( $robotsTxtMock );

		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_SPECIAL ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_TEMPLATE ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_TEMPLATE_TALK ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_USER ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $robotsTxtMock, NS_HELP ) );
	}

	public function testAllowedSpecialPages() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', null );

		$robotsTxtMock = $this->getRobotsTxtMock();
		$pathBuilderMock = $this->getPathBuilderMock();

		$wikiaRobots = new WikiaRobots( $pathBuilderMock );
		$wikiaRobots->configureRobotsBuilder( $robotsTxtMock );

		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Forum' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Sitemap' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Videos' ) );
		$this->assertFalse( $this->isSpecialPageAllowed( $robotsTxtMock, 'MyPage1' ) );
		$this->assertFalse( $this->isSpecialPageAllowed( $robotsTxtMock, 'MyPage2' ) );
	}

	public function testCustomRobotsRulesSingleSpecialPage() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', [ 'allowSpecialPage' => 'MyPage1' ] );

		$robotsTxtMock = $this->getRobotsTxtMock();
		$pathBuilderMock = $this->getPathBuilderMock();

		$wikiaRobots = new WikiaRobots( $pathBuilderMock );
		$wikiaRobots->configureRobotsBuilder( $robotsTxtMock );

		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Forum' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Sitemap' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Videos' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'MyPage1' ) );
		$this->assertFalse( $this->isSpecialPageAllowed( $robotsTxtMock, 'MyPage2' ) );
	}

	public function testCustomRobotsRulesMultipleSpecialPages() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', [ 'allowSpecialPage' => [ 'MyPage1', 'MyPage2' ] ] );

		$robotsTxtMock = $this->getRobotsTxtMock();
		$pathBuilderMock = $this->getPathBuilderMock();

		$wikiaRobots = new WikiaRobots( $pathBuilderMock );
		$wikiaRobots->configureRobotsBuilder( $robotsTxtMock );

		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Forum' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Sitemap' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Videos' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'MyPage1' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'MyPage2' ) );
	}

	public function testLocalSitemapAllowed() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgEnableLocalSitemap', true );
		$this->mockGlobalVariable( 'wgAllowSpecialImagesInRobots', false );

		$robotsTxtMock = $this->getRobotsTxtMock();
		$pathBuilderMock = $this->getPathBuilderMock();

		$wikiaRobots = new WikiaRobots( $pathBuilderMock );
		$wikiaRobots->configureRobotsBuilder( $robotsTxtMock );

		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Allpages' ) );
		$this->assertFalse( $this->isSpecialPageAllowed( $robotsTxtMock, 'Images' ) );
	}

	public function testSpecialImagesAllowed() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgEnableLocalSitemap', false );
		$this->mockGlobalVariable( 'wgAllowSpecialImagesInRobots', true );

		$robotsTxtMock = $this->getRobotsTxtMock();
		$pathBuilderMock = $this->getPathBuilderMock();

		$wikiaRobots = new WikiaRobots( $pathBuilderMock );
		$wikiaRobots->configureRobotsBuilder( $robotsTxtMock );

		$this->assertFalse( $this->isSpecialPageAllowed( $robotsTxtMock, 'Allpages' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $robotsTxtMock, 'Images' ) );
	}
}
