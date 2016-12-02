<?php
use Wikia\Helios\HelperController;

class HeliosHelperControllerTest extends WikiaBaseTest {

	public function test_shouldFailWithInvalidSecret() {
		$response = $this->app->sendRequest( 'Wikia\Helios\HelperController', 'sendPasswordResetLinkEmail', [] );
		$this->assertEquals( \WikiaResponse::RESPONSE_CODE_FORBIDDEN, $response->getCode() );
		$this->assertFalse( $response->getData()['success'] );
		$this->assertEquals( 'invalid secret', $response->getData()['message'] );
	}

	public function test_shouldFailInvalidToken() {
		global $wgTheSchwartzSecretToken;
		$response = $this->app->sendRequest( 'Wikia\Helios\HelperController', 'sendPasswordResetLinkEmail', [
			HelperController::SCHWARTZ_PARAM => $wgTheSchwartzSecretToken,
		] );

		$this->assertEquals( \WikiaResponse::RESPONSE_CODE_BAD_REQUEST, $response->getCode() );
		$this->assertFalse( $response->getData()['success'] );
		$this->assertEquals( HelperController::ERR_INVALID_TOKEN, $response->getData()['message'] );

		$response = $this->app->sendRequest( 'Wikia\Helios\HelperController', 'sendPasswordResetLinkEmail', [
			HelperController::SCHWARTZ_PARAM => $wgTheSchwartzSecretToken,
			'user_id'                        => 4,
		] );

		$this->assertEquals( \WikiaResponse::RESPONSE_CODE_BAD_REQUEST, $response->getCode() );
		$this->assertFalse( $response->getData()['success'] );
		$this->assertEquals( HelperController::ERR_INVALID_TOKEN, $response->getData()['message'] );
	}

	public function test_shouldFailInvalidUserId() {
		global $wgTheSchwartzSecretToken;
		$response = $this->app->sendRequest( 'Wikia\Helios\HelperController', 'sendPasswordResetLinkEmail', [
			HelperController::SCHWARTZ_PARAM => $wgTheSchwartzSecretToken,
			'token'                          => 'losowytoken',
		] );

		$this->assertEquals( \WikiaResponse::RESPONSE_CODE_BAD_REQUEST, $response->getCode() );
		$this->assertFalse( $response->getData()['success'] );
		$this->assertEquals( HelperController::ERR_INVALID_USER_ID, $response->getData()['message'] );
	}

	public function test_shouldFailUserNotFound() {
		global $wgTheSchwartzSecretToken;
		$response = $this->app->sendRequest( 'Wikia\Helios\HelperController', 'sendPasswordResetLinkEmail', [
			HelperController::SCHWARTZ_PARAM => $wgTheSchwartzSecretToken,
			'token'                          => 'validtoken',
			'user_id'                        => 'bad bad user id',
		] );

		$this->assertEquals( \WikiaResponse::RESPONSE_CODE_NOT_FOUND, $response->getCode() );
		$this->assertFalse( $response->getData()['success'] );
		$this->assertEquals( HelperController::ERR_INVALID_EMAIL, $response->getData()['message'] );
	}
	public function test_shouldFakeSendEmail() {
		global $wgTheSchwartzSecretToken;
		$appResponse = new WikiaResponse( 'json' );
		$appResponse->setData( [ 'result' => 'ok' ] );
		$appMock = $this->getMock( 'WikiaApp', [ 'sendRequest' ] );

		$appMock->expects( $this->once() )
			->method( 'sendRequest' )
			->willReturn( $appResponse );

		$requestMock = $this->getMock( 'WikiaRequest', [ 'getVal' ], [], '', false );
		$requestMock->expects( $this->any() )
			->method( 'getVal' )
			->will( $this->returnValueMap(
				[
					[ HelperController::SCHWARTZ_PARAM, '', $wgTheSchwartzSecretToken ],
					[ HelperController::EXTERNAL_SCHWARTZ_PARAM, '', '' ],
					[ 'token', null, 'validtoken' ],
					[ 'user_id', null, 5448086 ],
				]
			) );

		$userMock = $this->getMock( 'User', [ 'getEmail' ] );
		$userMock->expects( $this->any() )
			->method( 'getEmail' )
			->will( $this->returnValue( 'devbox@wikia-inc.com' ) );

		$this->mockClass( 'User', $userMock, 'newFromId' );

		$response = new WikiaResponse( 'json', $requestMock );

		$controller = new Wikia\Helios\HelperController();
		$controller->setRequest( $requestMock );
		$controller->setResponse( $response );
		$controller->setApp( $appMock );

		$controller->sendPasswordResetLinkEmail();

		$result = $controller->getResponse();

		$this->assertEquals( \WikiaResponse::RESPONSE_CODE_OK, $result->getCode() );
		$this->assertTrue( $result->getData()['success'] );
	}

}
