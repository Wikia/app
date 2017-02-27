<?php

/**
 * Unit test for WallExternalController, main AJAX entry point for Wall and Forum actions
 */
class WallExternalControllerTest extends WikiaBaseTest {
	const TEST_EDIT_TOKEN = 'Egy aprócska kalapocska, benne csacska macska mocska.';
	/**
	 * SUS-1387: Ensure WallExternalController::postNewMessage only works with Wall or Board NS
	 */
	public function testPostNewMessageWithWrongNamespace() {
		$requestParams = [
			'title' => 'czekaj, czekaj',
			'namespace' => 0,
			'body' => 'test content',
			'token' => static::TEST_EDIT_TOKEN
		];

		$user = $this->getMock( User::class, [ 'matchEditToken' ] );
		$user->expects( $this->once() )
			->method( 'matchEditToken' )
			->with( $this->equalTo( static::TEST_EDIT_TOKEN ) )
			->willReturn( true );

		$this->mockGlobalVariable( 'wgUser', $user );

		/** @var PHPUnit_Framework_MockObject_MockObject|WikiaRequest $request */
		$request = $this->getMock( WikiaRequest::class, [ 'isInternal', 'wasPosted' ], [ $requestParams ] );
		$request->expects( $this->any() )
			->method( 'isInternal' )
			->willReturn( false );

		$request->expects( $this->once() )
			->method( 'wasPosted' )
			->willReturn( true );

		$context = new DerivativeContext( RequestContext::getMain() );
		$context->setTitle( Wikia::createTitleFromRequest( $request ) );
		$wallExternalController = new WallExternalController();
		$wallExternalController->setContext( $context );
		$wallExternalController->setRequest( $request );
		$wallExternalController->setResponse( new WikiaResponse( WikiaResponse::FORMAT_JSON, $request ) );
		$wallExternalController->init();
		$wallExternalController->postNewMessage();
		$res = $wallExternalController->getResponse();

		$this->assertEquals( WikiaResponse::RESPONSE_CODE_BAD_REQUEST, $res->getCode(), 'WallExternalController::postNewMessage must only work with Wall and Board namespace' );
		$this->assertFalse( $res->getVal( 'status' ) );
	}

	/**
	 * SUS-1716: Verify that blocked user cannot change state of Wall/Forum content (post message, move thread etc.)
	 */
	public function testBlockedUserIsPreventedFromStateChangingMethods() {
		$blockedMethods = WallExternalController::BLOCKED_USER_PREVENTED_FROM_METHODS;
		$blockedMethodsCount = count( $blockedMethods );
		$maybeAllowedMethods = WallExternalController::BLOCKED_USER_MAYBE_ALLOWED_ON_OWN_WALL_METHODS;
		$maybeAllowedMethodsCount = count( $maybeAllowedMethods );

		$userTalk = new Title();

		/** @var PHPUnit_Framework_MockObject_MockObject|Title $titleMock */
		$titleMock = $this->getMock( Title::class, [ 'equals', 'getSubjectPage' ] );
		$titleMock->expects( $this->exactly( 2 * $maybeAllowedMethodsCount ) )
			->method( 'equals' )
			->with( $userTalk )
			->willReturn( false );
		$titleMock->expects( $this->exactly( $maybeAllowedMethodsCount ) )
			->method( 'getSubjectPage' )
			->willReturnSelf();

		/** @var PHPUnit_Framework_MockObject_MockObject|User $userMock */
		$userMock = $this->getMock( User::class, [ 'isBlocked', 'getBlock', 'getTalkPage' ] );
		$userMock->expects( $this->exactly( $blockedMethodsCount ) )
			->method( 'getTalkPage' )
			->willReturn( $userTalk );
		$userMock->expects( $this->exactly( $blockedMethodsCount ) )
			->method( 'isBlocked' )
			->willReturn( true );
		$userMock->expects( $this->exactly( $blockedMethodsCount ) )
			->method( 'getBlock' )
			->willReturn( new Block() );

		$context = new DerivativeContext( RequestContext::getMain() );
		$context->setTitle( $titleMock );
		$wallExternalController = new WallExternalController();
		$wallExternalController->setContext( $context );

		foreach ( $blockedMethods as $method ) {
			$wallExternalController->setResponse( new WikiaResponse( WikiaResponse::FORMAT_INVALID ) );

			$result = $wallExternalController->preventBlockedUsage( $userMock, $method );
			$response = $wallExternalController->getResponse();

			$this->assertTrue( $result, "Blocked user must be prevented from accessing WallExternalController::$method endpoint" );
			$this->assertEquals( WikiaResponse::RESPONSE_CODE_FORBIDDEN, $response->getCode(), 'Error code 403 must be set' );
			$this->assertEquals( WikiaResponse::FORMAT_JSON, $response->getFormat(), 'Error must be returned in JSON format' );
			$this->assertArrayHasKey( 'blockInfo', $response->getData(), 'Error must contain block info.' );
		}
	}

	/**
	 * SUS-1716: Verify that blocked user can still do things on their own Wall if permitted in block options
	 */
	public function testBlockedUserCanAccessSomeStateChangingMethodsOnOwnWallIfPermitted() {
		$blockedMethods = WallExternalController::BLOCKED_USER_PREVENTED_FROM_METHODS;
		$blockedMethodsCount = count( $blockedMethods );
		$allowedMethods = WallExternalController::BLOCKED_USER_MAYBE_ALLOWED_ON_OWN_WALL_METHODS;
		$allowedMethodsCount = count( $allowedMethods );
		$alwaysBlockedMethodsCount = $blockedMethodsCount - $allowedMethodsCount;

		$userTalk = new Title();
		/** @var PHPUnit_Framework_MockObject_MockObject|Title $titleMock */
		$titleMock = $this->getMock( Title::class, [ 'getTalkPage', 'equals' ] );
		$titleMock->expects( $this->exactly( $allowedMethodsCount ) )
			->method( 'getTalkPage' )
			->willReturnSelf();
		$titleMock->expects( $this->exactly( $allowedMethodsCount ) )
			->method( 'equals' )
			->with( $userTalk )
			->willReturn( true );

		/** @var PHPUnit_Framework_MockObject_MockObject|User $userMock */
		$userMock = $this->getMock( User::class, [ 'isBlockedFrom', 'isBlocked', 'getBlock', 'getTalkPage' ] );
		$userMock->expects( $this->exactly( $blockedMethodsCount ) )
			->method( 'getTalkPage' )
			->willReturn( $userTalk );
		$userMock->expects( $this->exactly( $allowedMethodsCount ) )
			->method( 'isBlockedFrom' )
			->with( $titleMock )
			->willReturn( false );
		$userMock->expects( $this->exactly( $alwaysBlockedMethodsCount ) )
			->method( 'isBlocked' )
			->willReturn( true );
		$userMock->expects( $this->exactly( $alwaysBlockedMethodsCount ) )
			->method( 'getBlock' )
			->willReturn( new Block() );

		$context = new DerivativeContext( RequestContext::getMain() );
		$context->setTitle( $titleMock );
		$wallExternalController = new WallExternalController();
		$wallExternalController->setContext( $context );

		foreach ( $blockedMethods as $method ) {
			$wallExternalController->setResponse( new WikiaResponse( WikiaResponse::FORMAT_INVALID ) );

			$result = $wallExternalController->preventBlockedUsage( $userMock, $method );
			$response = $wallExternalController->getResponse();

			if ( !in_array( $method, $allowedMethods ) ) {
				$this->assertTrue( $result, "Blocked user must be prevented from accessing WallExternalController::$method endpoint" );
				$this->assertEquals( WikiaResponse::RESPONSE_CODE_FORBIDDEN, $response->getCode(), 'Error code 403 must be set' );
				$this->assertEquals( WikiaResponse::FORMAT_JSON, $response->getFormat(), 'Error must be returned in JSON format' );
				$this->assertArrayHasKey( 'blockInfo', $response->getData(), 'Error must contain block info.' );
			} else {
				$this->assertFalse( $result, "Blocked user must be allowed to access WallExternalController::$method endpoint on own wall" );
				$this->assertEmpty( $response->getData(), 'Response must not be modified if action is allowed' );
			}
		}
	}
}
