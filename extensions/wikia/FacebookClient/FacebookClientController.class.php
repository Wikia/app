<?php

use Wikia\Logger\WikiaLogger;

class FacebookClientController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function preferences() {
		$this->response->addAsset( 'facebook_client_preferences_scss' );

		$this->isConnected = $this->getVal( 'isConnected', false );

		// Settings for a connected user
		$this->facebookDisconnectLink = wfMessage( 'fbconnect-disconnect-link' )->parse();
		$this->fbFromExist = F::app()->wg->User->getOption( 'fbFromExist' );

		// Settings for a user who is not connected yet
		$this->facebookConvertMessage = wfMessage( 'fbconnect-convert' )->plain();

		$this->facebookButton = F::app()->renderView( 'FacebookButton', 'index', [
			'class' => 'sso-login-facebook',
			'text' => wfMessage( 'fbconnect-wikia-signup-w-facebook' )->escaped()
		] );
	}

	/**
	 * This method is called from Facebook's side whenever a user deletes the Wikia app from their account.  Most
	 * of the functionality is based on the example given on Facebook:
	 *
	 * https://developers.facebook.com/docs/facebook-login/using-login-with-games/#parsingsr
	 *
	 * Additional general information on the callback here:
	 *
	 * https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow/v2.1#deauth-callback
	 *
	 */
	public function deauthorizeCallback() {
		global $fbAppSecret;

		$log = WikiaLogger::instance();

		$signedRequest = $this->getVal( 'signed_request', '' );

		list( $encodedSig, $payload ) = explode( '.', $signedRequest, 2 );

		// decode the data
		$sig = $this->base64UrlDecode( $encodedSig );
		$data = json_decode( $this->base64UrlDecode( $payload ), true );

		// confirm the signature
		$expectedSig = hash_hmac( 'sha256', $payload, $fbAppSecret, $raw = true );
		if ( $sig !== $expectedSig ) {
			$log->info( 'Deauthorization callback received with invalid signature', [
				'method' => __METHOD__,
			] );
			return;
		}

		if ( empty( $data['user_id'] ) ) {
			$log->warning( 'Deauthorization callback received with missing user ID', [
				'method' => __METHOD__,
			] );
			return;
		}

		$facebookUserId = $data['user_id'];
		$map = FacebookMapModel::lookupFromFacebookID( $facebookUserId );
		if ( empty( $map ) ) {
			$log->info( 'Deauthorization callback received with no matching Wikia ID mapping found', [
				'method' => __METHOD__,
				'facebookId' => $facebookUserId,
			] );
			return;
		}

		// Send this to the normal disconnect action
		$res = $this->sendSelfRequest( 'disconnectFromFB', [ 'user' => $map->getWikiaUserId() ]);
		$status = $res->getVal( 'status', '' );

		$logResultParams = [
			'method' => __METHOD__,
			'facebookId' => $facebookUserId,
			'wikiaUserId' => $map->getWikiaUserId(),
		];

		if ( $status == 'ok' ) {
			$log->info( 'Deauthorization callback received and completed successfully', $logResultParams );
		} else {
			$log->error( 'Deauthorization callback received and did not complete', $logResultParams );
		}
	}

	/**
	 * This is part of the example code Facebook gave for parsing its signed requests.  See above method and:
	 *
	 * https://developers.facebook.com/docs/facebook-login/using-login-with-games/#parsingsr
	 *
	 * @param $input
	 *
	 * @return string
	 */
	private function base64UrlDecode( $input ) {
		return base64_decode( strtr( $input, '-_', '+/' ) );
	}

	/**
	 * This method is called from Facebook's side whenever a user deletes the Wikia app from their account.  Most
	 * of the functionality is based on the example given on Facebook:
	 *
	 * https://developers.facebook.com/docs/facebook-login/using-login-with-games/#parsingsr
	 *
	 * Additional general information on the callback here:
	 *
	 * https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow/v2.1#deauth-callback
	 *
	 */
	public function deauthorizeCallback() {
		global $fbAppSecret;

		$log = WikiaLogger::instance();

		$signedRequest = $this->getVal( 'signed_request', '' );

		list( $encodedSig, $payload ) = explode( '.', $signedRequest, 2 );

		// decode the data
		$sig = $this->base64UrlDecode( $encodedSig );
		$data = json_decode( $this->base64UrlDecode( $payload ), true );

		// confirm the signature
		$expectedSig = hash_hmac( 'sha256', $payload, $fbAppSecret, $raw = true );
		if ( $sig !== $expectedSig ) {
			$log->info( 'Deauthorization callback received with invalid signature', [
				'method' => __METHOD__,
			] );
			return;
		}

		if ( empty( $data['user_id'] ) ) {
			$log->warning( 'Deauthorization callback received with missing user ID', [
				'method' => __METHOD__,
			] );
			return;
		}

		$facebookUserId = $data['user_id'];
		$map = FacebookMapModel::lookupFromFacebookID( $facebookUserId );
		if ( empty( $map ) ) {
			$log->info( 'Deauthorization callback received with no matching Wikia ID mapping found', [
				'method' => __METHOD__,
				'facebookId' => $facebookUserId,
			] );
			return;
		}

		// Send this to the normal disconnect action
		$res = $this->sendSelfRequest( 'disconnectFromFB', [ 'user' => $map->getWikiaUserId() ]);
		$status = $res->getVal( 'status', '' );

		$logResultParams = [
			'method' => __METHOD__,
			'facebookId' => $facebookUserId,
			'wikiaUserId' => $map->getWikiaUserId(),
		];

		if ( $status == 'ok' ) {
			$log->info( 'Deauthorization callback received and completed successfully', $logResultParams );
		} else {
			$log->error( 'Deauthorization callback received and did not complete', $logResultParams );
		}
	}

	/**
	 * This is part of the example code Facebook gave for parsing its signed requests.  See above method and:
	 *
	 * https://developers.facebook.com/docs/facebook-login/using-login-with-games/#parsingsr
	 *
	 * @param $input
	 *
	 * @return string
	 */
	private function base64UrlDecode( $input ) {
		return base64_decode( strtr( $input, '-_', '+/' ) );
	}

	/**
	 * Disconnect the user from Facebook
	 *
	 * @requestParam user This is a user object.  Only works for internal calls
	 */
	public function disconnectFromFB() {
		$user = $this->getVal( 'user', null );

		if ( $user ) {
			$user = User::newFromId( $user );
		} else {
			$user = F::app()->wg->User;
		}

		FacebookMapModel::deleteFromWikiaID( $user->getId() );

		$params = new FauxRequest( [ 'wpName' => $user->getName() ] );
		$loginForm = new LoginForm( $params );

		if ( $user->getOption( 'fbFromExist' ) ) {
			$res = $loginForm->mailPasswordInternal( $user, true, 'fbconnect-passwordremindertitle-exist', 'fbconnect-passwordremindertext-exist' );
		} else {
			$res = $loginForm->mailPasswordInternal( $user, true, 'fbconnect-passwordremindertitle', 'fbconnect-passwordremindertext' );
		}

		if ( $res->isGood() ) {
			$this->status = 'ok';
		} else {
			$this->status = 'error';
			$this->msg = wfMessage( 'fbconnect-unknown-error' )->text();
		}
	}

	/**
	 * Ajax endpoint for connecting a logged in Wikia user to a Facebook account.
	 * By the time they get here they should already have logged into Facebook and have a Facebook user ID.
	 *
	 * @throws FacebookMapModelInvalidDataException
	 */
	public function connectLoggedInUser() {
		$wg = F::app()->wg;

		$fb = FacebookClient::getInstance();
		$fbUserId = $fb->getUserId();

		// The user must be logged into Facebook and wikia
		if ( !$fbUserId || !$wg->User->isLoggedIn() ) {
			$this->status = 'error';
			return true;
		}

		$map = new FacebookMapModel();
		$map->relate( $wg->User->getId(), $fbUserId );
		$map->save();

		$this->status = 'ok';

		$this->track( 'facebook-link-existing' );
	}

	/**
	 * Track an event with a given label with user-sign-up category
	 * @param string $label
	 * @param string $action optional, 'submit' by default
	 */
	protected function track( $label, $action = 'submit' ) {
		\Track::event( 'trackingevent', [
			'ga_action' => $action,
			'ga_category' => 'user-sign-up',
			'ga_label' => $label,
			'beacon' => !empty( F::app()->wg->DevelEnvironment ) ? 'ThisIsFake' : wfGetBeaconId(),
		] );
	}
}
