<?php

use Wikia\RobotsTxt\RobotsTxt;

class RobotsTxtTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/RobotsTxt/RobotsTxt.setup.php";
		parent::setUp();
	}

	/**
	 * Test Wikia\RobotsTxt\RobotsTxt API
	 *
	 * @covers       addAllowedPaths::addAllowPaths
	 * @covers       RobotsTxtBuilder::allowDisallowPaths
	 * @covers       RobotsTxtBuilder::addBlockedRobots
	 * @covers       RobotsTxtBuilder::getContents
	 * @dataProvider dataProviderClassApi
	 *
	 * @param string[]|null $allowPaths argument passed to $robots->allowPaths (null for don't call it)
	 * @param string[]|null $disallowPaths argument passed to $robots->disallowPaths (null for don't call it)
	 * @param string[]|null $blockRobots argument passed to $robots->blockRobots (null for don't call it)
	 * @param string[] $expectedContents expected $robots->getContents()
	 */
	public function testClassApi( $allowPaths, $disallowPaths, $blockRobots, $expectedContents ) {
		$robots = new RobotsTxt();
		if ( !is_null( $allowPaths ) ) {
			$robots->addAllowedPaths( $allowPaths );
		}
		if ( !is_null( $disallowPaths ) ) {
			$robots->addDisallowedPaths( $disallowPaths );
		}
		if ( !is_null( $blockRobots ) ) {
			$robots->addBlockedRobots( $blockRobots );
		}
		$this->assertEquals( $expectedContents, $robots->getContents() );
	}

	/**
	 * Test Wikia\RobotsTxt\RobotsTxt API, other method call order
	 *
	 * @covers       addAllowedPaths::addAllowPaths
	 * @covers       RobotsTxtBuilder::allowDisallowPaths
	 * @covers       RobotsTxtBuilder::addBlockedRobots
	 * @covers       RobotsTxtBuilder::getContents
	 * @dataProvider dataProviderClassApi
	 *
	 * @param string[]|null $allowPaths argument passed to $robots->allowPaths (null for don't call it)
	 * @param string[]|null $disallowPaths argument passed to $robots->disallowPaths (null for don't call it)
	 * @param string[]|null $blockRobots argument passed to $robots->blockRobots (null for don't call it)
	 * @param string[] $expectedContents expected $robots->getContents()
	 */
	public function testClassApiTwistedOrder( $allowPaths, $disallowPaths, $blockRobots, $expectedContents ) {
		$robots = new RobotsTxt();
		if ( !is_null( $disallowPaths ) ) {
			$robots->addDisallowedPaths( $disallowPaths );
		}
		if ( !is_null( $blockRobots ) ) {
			$robots->addBlockedRobots( $blockRobots );
		}
		if ( !is_null( $allowPaths ) ) {
			$robots->addAllowedPaths( $allowPaths );
		}
		$this->assertEquals( $expectedContents, $robots->getContents() );
	}

	public function dataProviderClassApi() {
		return [
			// Empty
			[ null, null, null, [] ],
			[ [], [], [], [] ],

			// Non-empty:
			[
				[ '/abc', '/def' ],
				[ '/xyz', '/123' ],
				[ 'Nasty-bot', 'Another-bot', 'My-bot' ],
				[
					'User-agent: Nasty-bot',
					'Disallow: /',
					'',
					'User-agent: Another-bot',
					'Disallow: /',
					'',
					'User-agent: My-bot',
					'Disallow: /',
					'',
					'User-agent: *',
					'Allow: /abc',
					'Allow: /def',
					'Disallow: /xyz',
					'Disallow: /123',
					'Noindex: /xyz',
					'Noindex: /123',
					'',
				]
			],

			// Query params, special characters, utf-8
			[
				[
					'/abc',
					'/abc?query=def',
					'noslash',
				],
				[
					'noencoding%aaa$^%!#^',
					'spaces and utf-8: ąść',
					'Japanese chars: サイトマップ',
					'encoded Japanese chars: %E3%82%B5',
				],
				[ 'ąśćbot' ],
				[
					'User-agent: ąśćbot',
					'Disallow: /',
					'',
					'User-agent: *',
					'Allow: /abc',
					'Allow: /abc?query=def',
					'Allow: noslash',
					'Disallow: noencoding%aaa$^%!#^',
					'Disallow: spaces and utf-8: ąść',
					'Disallow: Japanese chars: サイトマップ',
					'Disallow: encoded Japanese chars: %E3%82%B5',
					'Noindex: noencoding%aaa$^%!#^',
					'Noindex: spaces and utf-8: ąść',
					'Noindex: Japanese chars: サイトマップ',
					'Noindex: encoded Japanese chars: %E3%82%B5',
					'',
				]
			],
		];
	}

	/**
	 * Test the methods called more times
	 *
	 * @covers       addAllowedPaths::addAllowPaths
	 */
	public function testAllowPathsCalledTwice() {
		$robots = new RobotsTxt();

		$robots->addAllowedPaths( [ '/abc', '/def' ] );
		$robots->addBlockedRobots( [ 'Robot1', 'Robot2' ] );
		$robots->addDisallowedPaths( [ '/efg', '/hij' ] );

		$robots->addAllowedPaths( [ '/pqr' ] );
		$robots->addDisallowedPaths( [ '/tuv' ] );
		$robots->addBlockedRobots( [ 'Single Robot' ] );

		$robots->addBlockedRobots( [ 'Robot3', 'Robot4' ] );
		$robots->addAllowedPaths( [ '/xyz', '/123' ] );
		$robots->addDisallowedPaths( [ '/456', '/789' ] );

		$this->assertEquals(
			[
				'User-agent: Robot1',
				'Disallow: /',
				'',
				'User-agent: Robot2',
				'Disallow: /',
				'',
				'User-agent: Single Robot',
				'Disallow: /',
				'',
				'User-agent: Robot3',
				'Disallow: /',
				'',
				'User-agent: Robot4',
				'Disallow: /',
				'',
				'User-agent: *',
				'Allow: /abc',
				'Allow: /def',
				'Allow: /pqr',
				'Allow: /xyz',
				'Allow: /123',
				'Disallow: /efg',
				'Disallow: /hij',
				'Disallow: /tuv',
				'Disallow: /456',
				'Disallow: /789',
				'Noindex: /efg',
				'Noindex: /hij',
				'Noindex: /tuv',
				'Noindex: /456',
				'Noindex: /789',
				'',
			],
			$robots->getContents()
		);
	}

	/**
	 * Test setSitemap
	 *
	 * @covers RobotsTxt::setSitemap
	 */
	public function testSetSitemap() {
		$robots = new RobotsTxt();
		$robots->setSitemap( 'http://www.my-site.com/sitemap.xml' );

		$this->assertEquals(
			[ 'Sitemap: http://www.my-site.com/sitemap.xml' ],
			$robots->getContents()
		);
	}

	/**
	 * Test setSitemap with other methods
	 *
	 * @covers RobotsTxt::setSitemap
	 */
	public function testSitemapWithOtherMethods() {
		$robots = new RobotsTxt();
		$robots->addAllowedPaths( [ '/abc' ] );
		$robots->setSitemap( 'http://www.my-site.com/sitemap.xml' );
		$robots->addDisallowedPaths( [ '/def' ] );
		$robots->addBlockedRobots( [ 'my-robot' ] );

		$this->assertEquals(
			[
				'User-agent: my-robot',
				'Disallow: /',
				'',
				'User-agent: *',
				'Allow: /abc',
				'Disallow: /def',
				'Noindex: /def',
				'',
				'Sitemap: http://www.my-site.com/sitemap.xml',
			],
			$robots->getContents()
		);
	}
}
