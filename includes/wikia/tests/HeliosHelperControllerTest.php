<?php
use Wikia\Helios\HelperController;

class HeliosHelperControllerTest extends WikiaBaseTest {

	const MESSAGE = 'message';

	const USER_ID = 'user_id';

	const SUCCESS = 'success';

	const TOKEN = 'reset_token';

	const WIKIA_HELIOS_HELPER_CONTROLLER = 'Wikia\Helios\HelperController';

	const METHOD_SEND_PWD_RESET_LINK_EMAIL = 'sendPasswordResetLinkEmail';

	/**
	 * @expectedException ForbiddenException
	 */
	public function test_shouldFailWithInvalidSecret() {
		$response = $this->app->sendRequest( self::WIKIA_HELIOS_HELPER_CONTROLLER, self::METHOD_SEND_PWD_RESET_LINK_EMAIL, [] );
	}

	public function test_shouldFailInvalidToken() {
		global $wgTheSchwartzSecretToken;
		$response = $this->app->sendRequest( self::WIKIA_HELIOS_HELPER_CONTROLLER, self::METHOD_SEND_PWD_RESET_LINK_EMAIL, [
			HelperController::SCHWARTZ_PARAM => $wgTheSchwartzSecretToken,
		] );

		$this->assertEquals( \WikiaResponse::RESPONSE_CODE_BAD_REQUEST, $response->getCode() );
		$this->assertFalse( $response->getData()[ self::SUCCESS ] );
		$this->assertEquals( HelperController::ERR_INVALID_TOKEN, $response->getData()[ self::MESSAGE ] );

		$response = $this->app->sendRequest( self::WIKIA_HELIOS_HELPER_CONTROLLER, self::METHOD_SEND_PWD_RESET_LINK_EMAIL, [
			HelperController::SCHWARTZ_PARAM => $wgTheSchwartzSecretToken,
			self::USER_ID                    => 4,
		] );

		$this->assertEquals( \WikiaResponse::RESPONSE_CODE_BAD_REQUEST, $response->getCode() );
		$this->assertFalse( $response->getData()[ self::SUCCESS ] );
		$this->assertEquals( HelperController::ERR_INVALID_TOKEN, $response->getData()[ self::MESSAGE ] );
	}

	public function test_shouldFailInvalidUserId() {
		global $wgTheSchwartzSecretToken;
		$response = $this->app->sendRequest( self::WIKIA_HELIOS_HELPER_CONTROLLER, self::METHOD_SEND_PWD_RESET_LINK_EMAIL, [
			HelperController::SCHWARTZ_PARAM => $wgTheSchwartzSecretToken,
			self::TOKEN                      => 'losowytoken',
		] );

		$this->assertEquals( \WikiaResponse::RESPONSE_CODE_BAD_REQUEST, $response->getCode() );
		$this->assertFalse( $response->getData()[ self::SUCCESS ] );
		$this->assertEquals( HelperController::ERR_INVALID_USER_ID, $response->getData()[ self::MESSAGE ] );
	}

	public function test_shouldFailUserNotFound() {
		global $wgTheSchwartzSecretToken;
		$response = $this->app->sendRequest( self::WIKIA_HELIOS_HELPER_CONTROLLER, self::METHOD_SEND_PWD_RESET_LINK_EMAIL, [
			HelperController::SCHWARTZ_PARAM => $wgTheSchwartzSecretToken,
			self::TOKEN                      => 'validtoken',
			self::USER_ID                    => 'bad bad user id',
		] );

		$this->assertEquals( \WikiaResponse::RESPONSE_CODE_NOT_FOUND, $response->getCode() );
		$this->assertFalse( $response->getData()[ self::SUCCESS ] );
		$this->assertEquals( HelperController::ERR_INVALID_EMAIL, $response->getData()[ self::MESSAGE ] );
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
					[ self::TOKEN, null, 'validtoken' ],
					[ self::USER_ID, null, 5448086 ],
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
		$this->assertTrue( $result->getData()[ self::SUCCESS ] );
	}

}
