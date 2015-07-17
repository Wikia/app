<?php

use Wikia\Logger\WikiaLogger;

class FacebookClientController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/** @var \FacebookClientFactory */
	protected $fbClientFactory;

	public function __construct() {
		parent::__construct();

		$this->fbClientFactory = new \FacebookClientFactory();
	}

	public function preferences() {
		JSMessages::enqueuePackage( 'FacebookClient', JSMessages::EXTERNAL );

		$this->response->addAsset( 'facebook_client_preferences_scss' );

		$isUserConnected = $this->getVal( 'isConnected', false );

		// Settings for a connected user
		$disconnectLink = wfMessage( 'fbconnect-disconnect-account-link' )->parse();
		$fbFromExist = F::app()->wg->User->getGlobalFlag( 'fbFromExist' );

		// Settings for a user who is not connected yet
		$convertMessage = wfMessage( 'fbconnect-convert' )->plain();

		$connectButton = F::app()->renderView( 'FacebookButton', 'index', [
			'class' => 'sso-login-facebook',
			'text' => wfMessage( 'prefs-fbconnect-prefstext' )->escaped()
		] );
		$disconnectButton = F::app()->renderView( 'FacebookButton', 'index', [
			'class' => 'fb-disconnect',
			'text' => wfMessage( 'prefs-fbconnect-disconnect-prefstext' )->escaped()
		] );

		$this->response->setData( [
			'isConnected' => $isUserConnected,
			'fbFromExist' => $fbFromExist,
			'connectButton' => $connectButton,
			'disconnectButton' => $disconnectButton,
			'convertMessage' => $convertMessage,
			'disconnectLink' => $disconnectLink,
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
	 * Disconnect the user from Facebook. This can occur in one of two ways, either when the user
	 * deletes the Wikia App from facebook, or when they explicitly disconnect via Special:Preferences.
	 * If it comes from Facebook, the request is internal and is sent by FacebookClientController::deauthorizeCallback.
	 * If it comes explicitly from the user, the request is external and is sent by preferences.js::disconnect.
	 *
	 * @requestParam user This is a user object.
	 */
	public function disconnectFromFB() {

		if ( $this->request->isInternal() ) {
			// deauthorizeCallback which makes this internal request ensures 'user' is set
			$userId = $this->getVal( 'user' );
			$user = User::newFromId( $userId );
		} elseif ( $this->isValidExternalRequest() ) {
			$user = F::app()->wg->User;
		} else {
			$this->status = 'error';
			$this->msg = wfMessage( 'fbconnect-unknown-error' )->escaped();
			return;
		}

		FacebookMapModel::deleteFromWikiaID( $user->getId() );

		// Create a temporary password for the user
		$userService = new \UserService();
		$tempPass = $userService->resetPassword( $user );

		// Send email to user with temp password, telling them their FB account is disconnected
		$emailParams = [
			'targetUser' => $user,
			'tempPass' => $tempPass,
		];
		$response = F::app()->sendRequest( 'Email\Controller\FacebookDisconnect', 'handle', $emailParams );

		if ( $response->getData()['result'] === 'ok' ) {
			$this->status = 'ok';
		} else {
			$this->status = 'error';
			$this->msg = wfMessage( 'fbconnect-unknown-error' )->text();
		}
	}

	/**
	 * Checks the validity of the request, making sure that it was both posted
	 * and that the user has a valid CSRF token
	 * @return bool
	 */
	private function isValidExternalRequest() {
		return ( $this->request->wasPosted() && $this->wg->User->matchEditToken( $this->getVal( 'token' ) ) );
	}

	/**
	 * Ajax endpoint for connecting a logged in Wikia user to a Facebook account.
	 * By the time they get here they should already have logged into Facebook and have a Facebook user ID.
	 */
	public function connectLoggedInUser() {
		$wg = F::app()->wg;

		$fb = FacebookClient::getInstance();
		$fbUserId = $fb->getUserId();

		// The user must be logged into Facebook and Wikia
		if ( !$fbUserId || !$wg->User->isLoggedIn() ) {
			$this->status = 'error';
			return;
		}

		// Create user mapping
		$status = $this->fbClientFactory->connectToFacebook( $wg->User->getId(), $fbUserId );
		if ( !$status->isGood() ) {
			list( $message, $params ) = $this->fbClientFactory->getStatusError( $status );
			$this->setErrorResponse( $message, $params );
			return;
		}

		$this->status = 'ok';

		\FacebookClientHelper::track( 'facebook-link-existing' );
	}

	/**
	 * Set a normalized error response meant for Ajax calls
	 *
	 * @param string $messageKey i18n error message key
	 * @param array $messageParams
	 */
	protected function setErrorResponse( $messageKey, array $messageParams = [] ) {
		$this->response->setData( [
			'status' => 'error',
			'msg' => wfMessage( $messageKey, $messageParams )->escaped(),
		] );
	}

}
