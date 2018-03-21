<?php

use Wikia\RobotsTxt\Robot;
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
	 * @covers       RobotsTxt::addRobot
	 * @dataProvider dataProviderClassApi
	 *
	 * @param string[]|null $allowPaths argument passed to $robots->allowPaths (null for don't call it)
	 * @param string[]|null $disallowPaths argument passed to $robots->disallowPaths (null for don't call it)
	 * @param string[] $expectedContents expected $robots->getContents()
	 */
	public function testClassApi( $allowPaths, $disallowPaths, $expectedContents ) {
		$robots = new RobotsTxt();
		$robot = new Robot( '*' );

		$robots->addRobot( $robot );

		if ( !is_null( $allowPaths ) ) {
			$robot->allowPaths( $allowPaths );
		}
		if ( !is_null( $disallowPaths ) ) {
			$robot->disallowPaths( $disallowPaths );
		}
		$this->assertEquals( $expectedContents, $robots->getContents() );
	}

	public function dataProviderClassApi() {
		return [
			// Empty
			[ null, null, [ 'User-agent: *' , 'Disallow: ', '' ] ],
			[ [], [], [ 'User-agent: *' , 'Disallow: ', '' ] ],

			// Non-empty:
			[
				[ '/abc', '/def' ],
				[ '/xyz', '/123' ],
				[
					'User-agent: *',
					'Allow: /abc',
					'Allow: /def',
					'Noindex: /xyz',
					'Noindex: /123',
					'Disallow: /xyz',
					'Disallow: /123',
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
				[
					'User-agent: *',
					'Allow: /abc',
					'Allow: /abc?query=def',
					'Allow: noslash',
					'Noindex: noencoding%aaa$^%!#^',
					'Noindex: spaces and utf-8: ąść',
					'Noindex: Japanese chars: サイトマップ',
					'Noindex: encoded Japanese chars: %E3%82%B5',
					'Disallow: noencoding%aaa$^%!#^',
					'Disallow: spaces and utf-8: ąść',
					'Disallow: Japanese chars: サイトマップ',
					'Disallow: encoded Japanese chars: %E3%82%B5',
					'',
				]
			],
		];
	}

	/**
	 * Test the methods called more times
	 *
	 * @covers       RobotsTxt::addRobot
	 */
	public function testAllowPathsCalledTwice() {
		$robots = new RobotsTxt();

		$robot1 = new Robot( 'Robot1' );
		$robot1->block();
		$robot2 = new Robot( 'Robot2' );
		$robot2->allowPaths( [ '/abc' ] );

		$robots->addRobot( $robot1 );
		$robots->addRobot( $robot2 );

		$this->assertEquals(
			[
				'User-agent: Robot1',
				'Noindex: /',
				'Disallow: /',
				'',
				'User-agent: Robot2',
				'Allow: /abc',
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

		$robot = new Robot( 'Robot1' );
		$robot->allowPaths( [ '/abc' ] );
		$robot->disallowPaths( [ '/def' ] );
		
		$robots->addRobot( $robot );
		$robots->addRobot( new Robot( 'Robot2' ) );
		$robots->setSitemap( 'http://www.my-site.com/sitemap.xml' );

		$this->assertEquals(
			[
				'User-agent: Robot1',
				'Allow: /abc',
				'Noindex: /def',
				'Disallow: /def',
				'',
				'User-agent: Robot2',
				'Disallow: ',
				'',
				'Sitemap: http://www.my-site.com/sitemap.xml',
			],
			$robots->getContents()
		);
	}
}
