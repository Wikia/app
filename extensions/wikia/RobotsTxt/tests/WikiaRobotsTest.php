<?php

class WikiaRobotsTest extends WikiaBaseTest {
	/**
	 * Get mock for PathBuilder
	 *
	 * PathBuilder has a separate set of tests, so here we're injecting a mock here instead
	 *
	 * The way it works it returns one-item array for each of the mocked methods contructing
	 * the path like that:
	 *
	 *  * /path/for/ns/NS_ID for buildPathsForNamespace
	 *  * /path/for/page/PAGENAME for buildPathsForSpecialPage
	 *  * /path/for/param/PARAM for buildPathsForParam
	 *
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	private function getPathBuilderMock() {
		$pathBuilderMock = $this->getMockBuilder( 'PathBuilder' )->getMock();
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
	 * Test WikiaRobots builds a "Disallow: /" robots.txt on dev environment
	 */
	public function testDevEnvironment() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_DEV );

		$robotsMock = $this->getMockBuilder( 'RobotsTxt' )->getMock();
		$robotsMock->expects( $this->once() )->method( 'addDisallowedPaths' )->with( [ '/' ] );
		$robotsMock->expects( $this->never() )->method( 'addAllowedPaths' );
		$robotsMock->expects( $this->never() )->method( 'addBlockedRobots' );
		$robotsMock->expects( $this->never() )->method( 'setSitemap' );

		$wikiaRobots = new WikiaRobots( $this->getPathBuilderMock() );
		$wikiaRobots->configureRobotsBuilder( $robotsMock );
	}

	/**
	 * Test WikiaRobots sets the proper sitemap based on wgServer
	 */
	public function testSitemapEnabled() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgServer', 'http://server' );
		$this->mockGlobalVariable( 'wgEnableSpecialSitemapExt', true );

		$robotsMock = $this->getMockBuilder( 'RobotsTxt' )->getMock();
		$robotsMock->expects( $this->once() )->method( 'setSitemap' )->with( 'http://server/sitemap-index.xml' );

		$wikiaRobots = new WikiaRobots( $this->getPathBuilderMock() );
		$wikiaRobots->configureRobotsBuilder( $robotsMock );
	}

	/**
	 * Test WikiaRobots doesn't set the sitemap if wgEnableSpecialSitemapExt is false
	 */
	public function testSitemapDisabled() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgServer', 'http://server' );
		$this->mockGlobalVariable( 'wgEnableSpecialSitemapExt', false );

		$robotsMock = $this->getMockBuilder( 'RobotsTxt' )->getMock();
		$robotsMock->expects( $this->never() )->method( 'setSitemap' );

		$wikiaRobots = new WikiaRobots( $this->getPathBuilderMock() );
		$wikiaRobots->configureRobotsBuilder( $robotsMock );
	}

	/**
	 * Test function that checks if the given namespace is disallowed by given wikiaRobots
	 *
	 * @param WikiaRobots $wikiaRobots
	 * @param int $ns the namespace id
	 * @return bool
	 */
	private function isNamespaceDisallowed( WikiaRobots $wikiaRobots, $ns ) {
		$robotsMock = $this->getMockBuilder( 'RobotsTxt' )->getMock();

		$nsDisallowed = false;
		$robotsMock->expects( $this->any() )
			->method( 'addDisallowedPaths' )
			->willReturnCallback( function ( $paths ) use ( $ns, &$nsDisallowed ) {
				if ( in_array( '/path/for/ns/' . $ns, $paths ) ) {
					$nsDisallowed = true;
				}
			} );

		$nsAllowed = false;
		$robotsMock->expects( $this->any() )
			->method( 'addAllowedPaths' )
			->willReturnCallback( function ( $paths ) use ( $ns, &$nsAllowed ) {
				if ( in_array( '/path/for/ns/' . $ns, $paths ) ) {
					$nsAllowed = true;
				}
			} );

		$wikiaRobots->configureRobotsBuilder( $robotsMock );
		return $nsDisallowed && !$nsAllowed;
	}

	/**
	 * Test function that checks if the given special page is disallowed by given wikiaRobots
	 *
	 * @param WikiaRobots $wikiaRobots
	 * @param string $page the special page name (the one used in the special page definition)
	 * @return bool
	 */
	private function isSpecialPageAllowed( WikiaRobots $wikiaRobots, $page ) {
		$robotsMock = $this->getMockBuilder( 'RobotsTxt' )->getMock();

		$pageAllowed = false;
		$robotsMock->expects( $this->any() )
			->method( 'addAllowedPaths' )
			->willReturnCallback( function ( $paths ) use ( $page, &$pageAllowed ) {
				if ( in_array( '/path/for/page/' . $page, $paths ) ) {
					$pageAllowed = true;
				}
			} );

		$pageDisallowed = false;
		$robotsMock->expects( $this->any() )
			->method( 'addDisallowedPaths' )
			->willReturnCallback( function ( $paths ) use ( $page, &$pageDisallowed ) {
				if ( in_array( '/path/for/page/' . $page, $paths ) ) {
					$pageDisallowed = true;
				}
			} );

		$wikiaRobots->configureRobotsBuilder( $robotsMock );
		return $pageAllowed && !$pageDisallowed;
	}

	public function testDisallowedNamespaces() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', null );

		$wikiaRobots = new WikiaRobots( $this->getPathBuilderMock() );

		$this->assertTrue( $this->isNamespaceDisallowed( $wikiaRobots, NS_SPECIAL ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $wikiaRobots, NS_TEMPLATE ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $wikiaRobots, NS_TEMPLATE_TALK ) );
		$this->assertFalse( $this->isNamespaceDisallowed( $wikiaRobots, NS_USER ) );
		$this->assertFalse( $this->isNamespaceDisallowed( $wikiaRobots, NS_HELP ) );
	}

	public function testCustomRobotsRulesSingleNamespace() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', [ 'disallowNamespace' => NS_HELP ] );

		$wikiaRobots = new WikiaRobots( $this->getPathBuilderMock() );

		$this->assertTrue( $this->isNamespaceDisallowed( $wikiaRobots, NS_SPECIAL ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $wikiaRobots, NS_TEMPLATE ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $wikiaRobots, NS_TEMPLATE_TALK ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $wikiaRobots, NS_HELP ) );
		$this->assertFalse( $this->isNamespaceDisallowed( $wikiaRobots, NS_USER ) );
	}

	public function testCustomRobotsRulesMultipleNamespaces() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', [ 'disallowNamespace' => [ NS_USER, NS_HELP ] ] );

		$wikiaRobots = new WikiaRobots( $this->getPathBuilderMock() );

		$this->assertTrue( $this->isNamespaceDisallowed( $wikiaRobots, NS_SPECIAL ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $wikiaRobots, NS_TEMPLATE ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $wikiaRobots, NS_TEMPLATE_TALK ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $wikiaRobots, NS_USER ) );
		$this->assertTrue( $this->isNamespaceDisallowed( $wikiaRobots, NS_HELP ) );
	}

	public function testAllowedSpecialPages() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', null );

		$wikiaRobots = new WikiaRobots( $this->getPathBuilderMock() );

		$this->assertTrue( $this->isSpecialPageAllowed( $wikiaRobots, 'Forum' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $wikiaRobots, 'Sitemap' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $wikiaRobots, 'Videos' ) );
		$this->assertFalse( $this->isSpecialPageAllowed( $wikiaRobots, 'MyPage1' ) );
		$this->assertFalse( $this->isSpecialPageAllowed( $wikiaRobots, 'MyPage2' ) );
	}

	public function testCustomRobotsRulesSingleSpecialPage() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', [ 'allowSpecialPage' => 'MyPage1' ] );

		$wikiaRobots = new WikiaRobots( $this->getPathBuilderMock() );

		$this->assertTrue( $this->isSpecialPageAllowed( $wikiaRobots, 'Forum' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $wikiaRobots, 'Sitemap' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $wikiaRobots, 'Videos' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $wikiaRobots, 'MyPage1' ) );
		$this->assertFalse( $this->isSpecialPageAllowed( $wikiaRobots, 'MyPage2' ) );
	}

	public function testCustomRobotsRulesMultipleSpecialPages() {
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgRobotsTxtCustomRules', [ 'allowSpecialPage' => [ 'MyPage1', 'MyPage2' ] ] );

		$wikiaRobots = new WikiaRobots( $this->getPathBuilderMock() );

		$this->assertTrue( $this->isSpecialPageAllowed( $wikiaRobots, 'Forum' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $wikiaRobots, 'Sitemap' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $wikiaRobots, 'Videos' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $wikiaRobots, 'MyPage1' ) );
		$this->assertTrue( $this->isSpecialPageAllowed( $wikiaRobots, 'MyPage2' ) );
	}
}
