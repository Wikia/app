<?php

use Wikia\RobotsTxt\Robot;

class RobotTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/RobotsTxt/RobotsTxt.setup.php";
		parent::setUp();
	}

	/**
	 * Test Wikia\RobotsTxt\Robot API
	 *
	 * @covers       Robot::allowPaths
	 * @covers       Robot::disallowPaths
	 * @covers       Robot::setUserAgent
	 * @covers       Robot::getContent
	 * @dataProvider dataProviderClassApi
	 *
	 * @param string[]|null $allowPaths argument passed to $robot->allowPaths (null for don't call it)
	 * @param string[]|null $disallowPaths argument passed to $robot->disallowPaths (null for don't call it)
	 * @param string[]|null $userAgent argument passed to $robot->setUserAgent (null for don't call it)
	 * @param string[] $expectedContents expected $robots->getContent()
	 */
	public function testClassApi( $allowPaths, $disallowPaths, $userAgent, $expectedContents ) {
		$robot = new Robot( '*' );
		
		if ( !is_null( $userAgent ) ) {
			$robot->setUserAgent( $userAgent );
		}
		if ( !is_null( $allowPaths ) ) {
			$robot->allowPaths( $allowPaths );
		}
		if ( !is_null( $disallowPaths ) ) {
			$robot->disallowPaths( $disallowPaths );
		}
		$this->assertEquals( $expectedContents, $robot->getContent() );
	}

	/**
	 * Test Wikia\RobotsTxt\Robot API
	 *
	 * @covers       Robot::allowPaths
	 * @covers       Robot::disallowPaths
	 * @covers       Robot::setUserAgent
	 * @covers       Robot::getContent
	 * @dataProvider dataProviderClassApi
	 *
	 * @param string[]|null $allowPaths argument passed to $robot->allowPaths (null for don't call it)
	 * @param string[]|null $disallowPaths argument passed to $robot->disallowPaths (null for don't call it)
	 * @param string[]|null $userAgent argument passed to $robot->setUserAgent (null for don't call it)
	 * @param string[] $expectedContents expected $robots->getContent()
	 */
	public function testClassApiTwistedOrder( $allowPaths, $disallowPaths, $userAgent, $expectedContents ) {
		$robot = new Robot( '*' );
		
		if ( !is_null( $userAgent ) ) {
			$robot->setUserAgent( $userAgent );
		}
		if ( !is_null( $allowPaths ) ) {
			$robot->allowPaths( $allowPaths );
		}
		if ( !is_null( $disallowPaths ) ) {
			$robot->disallowPaths( $disallowPaths );
		}
		$this->assertEquals( $expectedContents, $robot->getContent() );
	}

	public function dataProviderClassApi() {
		return [
			// Empty
			[ null, null, '*', [ 'User-agent: *' , 'Disallow: ', '' ] ],
			[ [], [], '*', [ 'User-agent: *' , 'Disallow: ', '' ] ],

			// Non-empty:
			[
				[ '/abc', '/def' ],
				[ '/xyz', '/123' ],
				'Robot1',
				[
					'User-agent: Robot1',
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
				'ąśćbot',
				[
					'User-agent: ąśćbot',
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
	 * @covers       Robot::allowPaths
	 * @covers       Robot::disallowPaths
	 * @covers       Robot::block
	 */
	public function testAllowPathsCalledTwice() {
		$robot = new Robot( 'RobotXYZ' );

		$robot->allowPaths( [ '/abc', '/def' ] );
		$robot->disallowPaths( [ '/efg', '/hij' ] );

		$robot->allowPaths( [ '/pqr' ] );
		$robot->disallowPaths( [ '/tuv' ] );

		$robot->allowPaths( [ '/xyz', '/123' ] );
		$robot->disallowPaths( [ '/456', '/789' ] );

		$this->assertEquals(
			[
				'User-agent: RobotXYZ',
				'Allow: /abc',
				'Allow: /def',
				'Allow: /pqr',
				'Allow: /xyz',
				'Allow: /123',
				'Noindex: /efg',
				'Noindex: /hij',
				'Noindex: /tuv',
				'Noindex: /456',
				'Noindex: /789',
				'Disallow: /efg',
				'Disallow: /hij',
				'Disallow: /tuv',
				'Disallow: /456',
				'Disallow: /789',
				'',
			],
			$robot->getContent()
		);

		$robot->block();

		$this->assertEquals(
			[
				'User-agent: RobotXYZ',
				'Noindex: /',
				'Disallow: /',
				''
			],
			$robot->getContent()
		);
	}
}
