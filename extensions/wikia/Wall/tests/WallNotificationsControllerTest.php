<?php
class WallNotificationsControllerTest extends WikiaBaseTest {
	private $wgOutmScriptsCached = '';

	public function setUp() {
		parent::setUp();
		$this->wgOutmScriptsCached = $this->app->wg->Out->mScripts;
		$this->app->wg->Out->mScripts = '';
	}

	/**
	 * @param $isUserLoggedIn
	 * @param $isUserAllowed
	 * @param $wgAtCreateNewWikiPageValue
	 * @param $expectedInScriptString
	 *
	 * @dataProvider indexDataProvider
	 */
	public function testIndex( $isUserLoggedIn, $isUserAllowed, $wgAtCreateNewWikiPageValue, $hasPrehide ) {
		$userMock = $this->getMock( 'User', [ 'isLoggedIn', 'isAllowed' ], [], '', false );
		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue( $isUserLoggedIn ) );
		$userMock->expects( $this->any() )
			->method( 'isAllowed' )
			->will( $this->returnValue( $isUserAllowed ) );

		$this->mockGlobalVariable( 'wgAtCreateNewWikiPage', $wgAtCreateNewWikiPageValue );
		$this->mockGlobalVariable( 'wgUser', $userMock );

		$resp = $this->app->sendRequest( 'WallNotificationsController', 'Index' );
		$this->assertEquals( $hasPrehide, is_bool($resp->getVal('prehide')) );
	}

	public function indexDataProvider() {
		return [
			[
				'isUserLoggedIn' => true,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => null,
				'hasPrehide' => true,
				'undefined $wgAtCreateNewWikiPage and user IS logged-in and IS allowed to read -- assets ARE added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => null,
				'hasPrehide' => false,
				'undefined $wgAtCreateNewWikiPage and user IS NOT logged-in and IS allowed to read -- assets assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => false,
				'wgAtCreateNewWikiPageValue' => null,
				'hasPrehide' => false,
				'undefined $wgAtCreateNewWikiPage and user IS NOT logged-in and IS NOT allowed to read -- assets assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => false,
				'wgAtCreateNewWikiPageValue' => true,
				'hasPrehide' => false,
				'A create new wiki page and user IS NOT logged-in and IS NOT allowed to read -- assets assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => true,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => true,
				'hasPrehide' => false,
				'A create new wiki page and user IS logged-in and IS allowed to read -- assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => false,
				'wgAtCreateNewWikiPageValue' => false,
				'hasPrehide' => false,
				'NOT a create new wiki page and user IS NOT logged-in and IS NOT allowed to read -- assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => true,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => false,
				'hasPrehide' => true,
				'NOT a create new wiki page and user IS logged-in and IS allowed to read -- assets ARE added'
			],
		];
	}

	public function tearDown() {
		parent::tearDown();
		$this->app->wg->Out->mScripts = $this->wgOutmScriptsCached;
		$this->wgOutmScriptsCached = '';
	}

}
