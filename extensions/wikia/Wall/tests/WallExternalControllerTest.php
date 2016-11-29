<?php

/**
 * Unit test for WallExternalController, main AJAX entry point for Wall and Forum actions
 */
class WallExternalControllerTest extends WikiaBaseTest {
	const TEST_EDIT_TOKEN = 'Egy aprócska kalapocska, benne csacska macska mocska.';

	public function setUp() {
		parent::setUp();
		$user = $this->getMock( User::class, [ 'matchEditToken' ] );
		$user->expects( $this->once() )
			->method( 'matchEditToken' )
			->with( $this->equalTo( static::TEST_EDIT_TOKEN ) )
			->willReturn( true );

		$this->mockGlobalVariable( 'wgUser', $user );
	}

	/**
	 * SUS-1387: Ensure WallExternalController::postNewMessage only works with Wall or Board NS
	 */
	public function testPostNewMessageWithWrongNamespace() {
		$requestParams = [
			'controller' => 'WallExternalController',
			'method' => 'postNewMessage',
			'pagetitle' => 'czekaj, czekaj',
			'pagenamespace' => 0,
			'body' => 'test content',
			'token' => static::TEST_EDIT_TOKEN
		];

		/** @var PHPUnit_Framework_MockObject_MockObject|WikiaRequest $request */
		$request = $this->getMock( WikiaRequest::class, [ 'isInternal', 'wasPosted' ], [ $requestParams ] );
		$request->expects( $this->any() )
			->method( 'isInternal' )
			->willReturn( false );

		$request->expects( $this->once() )
			->method( 'wasPosted' )
			->willReturn( true );

		$res = $this->app->getDispatcher()->dispatch( $this->app, $request );

		$this->assertEquals( WikiaResponse::RESPONSE_CODE_BAD_REQUEST, $res->getCode(), 'WallExternalController::postNewMessage must only work with Wall and Board namespace' );
		$this->assertEquals( false, $res->getVal( 'status' ) );
	}
}
