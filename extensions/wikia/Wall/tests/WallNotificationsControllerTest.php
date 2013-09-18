<?php
class WallNotificationsControllerTest extends WikiaBaseTest {

	/**
	 * @param Boolean | null $wgAtCreateNewWikiPageValue mocked value of global variable
	 * @param Boolean $isUserAllowed mocked value about a user having the right
	 * @param Boolean $expected
	 * @param String $testDescription description passed to assertEquals() method
	 *
	 * @dataProvider areNotificationsSuppressedByExtensionsDataProvider
	 */
	public function testAreNotificationsSuppressedByExtensions( $wgAtCreateNewWikiPageValue, $isUserAllowed, $expected, $testDescription ) {
		$userMock = $this->getMock( 'User', [ 'isAllowed' ], [], '', false );
		$userMock->expects( $this->any() )
			->method( 'isAllowed' )
			->will( $this->returnValue( $isUserAllowed ) );

		$this->mockGlobalVariable( 'wgAtCreateNewWikiPage', $wgAtCreateNewWikiPageValue );
		$this->mockGlobalVariable( 'wgUser', $userMock );

		// let's test private method
		$areNotificationsSuppressedByExtensionsMethod = new ReflectionMethod( 'WallNotificationsController', 'areNotificationsSuppressedByExtensions' );
		$areNotificationsSuppressedByExtensionsMethod->setAccessible( true );

		$this->assertEquals( $expected, $areNotificationsSuppressedByExtensionsMethod->invoke( new WallNotificationsController() ), $testDescription );
	}

	public function areNotificationsSuppressedByExtensionsDataProvider() {
		return [
			[
				'wgAtCreateNewWikiPageValue' => null,
				'isUserAllowed' => true,
				'expected' => false,
				'undefined $wgAtCreateNewWikiPage and user IS allowed to read'
			],
			[
				'wgAtCreateNewWikiPageValue' => null,
				'isUserAllowed' => false,
				'expected' => true,
				'undefined $wgAtCreateNewWikiPage and user IS NOT allowed to read'
			],
			[
				'wgAtCreateNewWikiPageValue' => true,
				'isUserAllowed' => false,
				'expected' => true,
				'A create new wiki page and user IS NOT allowed to read'
			],
			[
				'wgAtCreateNewWikiPageValue' => true,
				'isUserAllowed' => true,
				'expected' => true,
				'A create new wiki page and user IS allowed to read'
			],
			[
				'wgAtCreateNewWikiPageValue' => false,
				'isUserAllowed' => false,
				'expected' => true,
				'NOT a create new wiki page and user IS NOT allowed to read'
			],
			[
				'wgAtCreateNewWikiPageValue' => false,
				'isUserAllowed' => true,
				'expected' => false,
				'NOT a create new wiki page and user IS allowed to read'
			]
		];
	}

}
