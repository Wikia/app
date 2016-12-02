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
}
