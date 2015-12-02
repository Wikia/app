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
	 * @param $hasPrehide
	 *
	 * @dataProvider indexDataProvider
	 */
	public function testIndex( $isUserLoggedIn, $isUserAllowed, $wgAtCreateNewWikiPageValue, $hasPrehide, $desc ) {
		$userMock = $this->getMock( 'User', [ 'isLoggedIn', 'isAllowed' ], [], '', false );
		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue( $isUserLoggedIn ) );
		$userMock->expects( $this->any() )
			->method( 'isAllowed' )
			->will( $this->returnValue( $isUserAllowed ) );

		$this->mockGlobalVariable( 'wgAtCreateNewWikiPage', $wgAtCreateNewWikiPageValue );
		$this->mockGlobalVariable( 'wgUser', $userMock );

		$resp = $this->app->sendRequest( 'WallNotificationsController', 'Index', [ 'format' => 'json' ] );
		$this->assertEquals( $hasPrehide, is_bool($resp->getVal('prehide')) );
	}

	public function indexDataProvider() {
		return [
			[
				'isUserLoggedIn' => true,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => null,
				'hasPrehide' => true,
				'1) undefined $wgAtCreateNewWikiPage and user IS logged-in and IS allowed to read -- assets ARE added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => null,
				'hasPrehide' => false,
				'2) undefined $wgAtCreateNewWikiPage and user IS NOT logged-in and IS allowed to read -- assets assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => false,
				'wgAtCreateNewWikiPageValue' => null,
				'hasPrehide' => false,
				'3) undefined $wgAtCreateNewWikiPage and user IS NOT logged-in and IS NOT allowed to read -- assets assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => false,
				'wgAtCreateNewWikiPageValue' => true,
				'hasPrehide' => false,
				'4) A create new wiki page and user IS NOT logged-in and IS NOT allowed to read -- assets assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => true,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => true,
				'hasPrehide' => false,
				'5) A create new wiki page and user IS logged-in and IS allowed to read -- assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => false,
				'wgAtCreateNewWikiPageValue' => false,
				'hasPrehide' => false,
				'6) NOT a create new wiki page and user IS NOT logged-in and IS NOT allowed to read -- assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => true,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => false,
				'hasPrehide' => true,
				'7) NOT a create new wiki page and user IS logged-in and IS allowed to read -- assets ARE added'
			],
		];
	}

	public function tearDown() {
		parent::tearDown();
		$this->app->wg->Out->mScripts = $this->wgOutmScriptsCached;
		$this->wgOutmScriptsCached = '';
	}

}
