<?php
class WallNotificationsControllerTest extends WikiaBaseTest {

	/**
	 * @param $isUserLoggedIn
	 * @param $isUserAllowed
	 * @param $wgAtCreateNewWikiPageValue
	 *
	 * @dataProvider indexDataProvider
	 */
	public function testIndex( $isUserLoggedIn, $isUserAllowed, $wgAtCreateNewWikiPageValue ) {
		$this->markTestSkipped( 'Somehow the $wgOut->mScripts has always WallNotifications.js -- I do not know why therefore tests is not ready yet.' );

		$userMock = $this->getMock( 'User', [ 'isLoggedIn', 'isAllowed' ], [], '', false );
		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue( $isUserLoggedIn ) );
		$userMock->expects( $this->any() )
			->method( 'isAllowed' )
			->will( $this->returnValue( $isUserAllowed ) );

		$this->mockGlobalVariable( 'wgAtCreateNewWikiPage', $wgAtCreateNewWikiPageValue );
		$this->mockGlobalVariable( 'wgUser', $userMock );

		$this->app->sendRequest( 'WallNotificationsController', 'Index' );
	}

	public function indexDataProvider() {
		return [
			[
				'isUserLoggedIn' => true,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => null,
				'undefined $wgAtCreateNewWikiPage and user IS logged-in and IS allowed to read -- assets ARE added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => null,
				'undefined $wgAtCreateNewWikiPage and user IS NOT logged-in and IS allowed to read -- assets assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => false,
				'wgAtCreateNewWikiPageValue' => null,
				'expectedIsUserSet' => false,
				'undefined $wgAtCreateNewWikiPage and user IS NOT logged-in and IS NOT allowed to read -- assets assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => false,
				'wgAtCreateNewWikiPageValue' => true,
				'expectedIsUserSet' => false,
				'A create new wiki page and user IS NOT logged-in and IS NOT allowed to read -- assets assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => true,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => true,
				'expectedIsUserSet' => false,
				'A create new wiki page and user IS logged-in and IS allowed to read -- assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => false,
				'wgAtCreateNewWikiPageValue' => false,
				'expectedIsUserSet' => false,
				'NOT a create new wiki page and user IS NOT logged-in and IS NOT allowed to read -- assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => true,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => false,
				'expectedIsUserSet' => true,
				'NOT a create new wiki page and user IS logged-in and IS allowed to read -- assets ARE added'
			],
		];
	}

}
