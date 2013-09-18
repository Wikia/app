<?php
class WallNotificationsControllerTest extends WikiaBaseTest {

	/**
	 * @param Boolean | null $wgAtCreateNewWikiPageValue mocked value of global variable
	 * @param Boolean $expected
	 * @param String $testDescription description passed to assertEquals() method
	 *
	 * @dataProvider areNotificationsSuppressedByExtensionsDataProvider
	 */
	public function testAreNotificationsSuppressedByExtensions( $wgAtCreateNewWikiPageValue, $expected, $testDescription ) {
		$this->mockGlobalVariable( 'wgAtCreateNewWikiPage', $wgAtCreateNewWikiPageValue );

		// let's test private method
		$areNotificationsSuppressedByExtensionsMethod = new ReflectionMethod( 'WallNotificationsController', 'areNotificationsSuppressedByExtensions' );
		$areNotificationsSuppressedByExtensionsMethod->setAccessible( true );

		$this->assertEquals( $expected, $areNotificationsSuppressedByExtensionsMethod->invoke( new WallNotificationsController() ), $testDescription );
	}

	public function areNotificationsSuppressedByExtensionsDataProvider() {
		return [
			[
				'wgAtCreateNewWikiPageValue' => null,
				'expected' => false,
				'$wgAtCreateNewWikiPage undefined'
			],
			[
				'wgAtCreateNewWikiPageValue' => true,
				'expected' => true,
				'$wgAtCreateNewWikiPage set to true'
			],
			[
				'wgAtCreateNewWikiPageValue' => false,
				'expected' => false,
				'$wgAtCreateNewWikiPage set to false'
			]
		];
	}

}