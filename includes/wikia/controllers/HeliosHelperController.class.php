<?php

namespace Wikia\Helios;

use Email\Controller\EmailConfirmationController;

/**
 * A helper controller to provide end points exposing MediaWiki functionality to Helios.
 */
class HelperController extends \WikiaController {
	const SCHWARTZ_PARAM = 'secret';
	const EXTERNAL_SCHWARTZ_PARAM = 'token';
	const ERR_USER_NOT_FOUND = 'user not found';
	const ERR_INVALID_EMAIL = 'invalid email';
	const ERR_COULD_NOT_SEND_AN_EMAIL_MESSAGE = 'could not send an email message';
	const ERR_INVALID_TOKEN = 'invalid token';
	const ERR_INVALID_USER_ID = 'invalid user_id';
	const FIELD_MESSAGE = 'message';
	const FIELD_ALLOW = 'allow';
	const FIELD_RESET_TOKEN = 'reset_token';
	const FIELD_TOKEN_CTX = 'token_ctx';
	const FIELD_RESULT = 'result';
	const FIELD_RETURN_URL = 'return_url';
	const FIELD_SUCCESS = 'success';
	const FIELD_USERNAME = 'username';
	const FACEBOOK_DISCONNECT_TOKEN_CONTEXT = 'facebook';

	public function init() {
		$this->response->setFormat( 'json' );
		$this->response->setCacheValidity( \WikiaResponse::CACHE_DISABLED );

		if ( !$this->authenticateViaTheSchwartz() ) {
			throw new \ForbiddenException( 'Invalid secret provided' );
		}
	}

	/**
	 * AntiSpoof: verify whether the name is legal for a new account.
	 *
	 * @see extensions/AntiSpoof
	 */
	public function checkAntiSpoof() {
		$this->response->setVal( self::FIELD_ALLOW, false );

		$username = $this->getVal( self::FIELD_USERNAME );

		// Allow the given user name if the AntiSpoof extension is disabled.
		if ( empty( $this->wg->EnableAntiSpoofExt ) ) {
			$this->response->setVal( self::FIELD_ALLOW, true );

			return;
		}

		$spoofUser = new \SpoofUser( $username );

		// Allow the given user name if it is legal and does not conflict with other names.
		$this->response->setVal( self::FIELD_ALLOW, $spoofUser->isLegal() && !$spoofUser->getConflicts( true ) );

		return;
	}

	/**
	 * Api endpoint to send a password reset e-mail.
	 * @requestParam user_id : \User::id
	 * @requestParam reset_token : user identification token
	 * @requestParam token_ctx : token context identifying the email content.
	 */
	public function sendPasswordResetLinkEmail() {
		$this->response->setVal( self::FIELD_SUCCESS, false );

		$userId = $this->getFieldFromRequest( 'user_id', self::ERR_INVALID_USER_ID );
		$token = $this->getFieldFromRequest( self::FIELD_RESET_TOKEN, self::ERR_INVALID_TOKEN );
		$returnUrl = $this->getVal( self::FIELD_RETURN_URL, null );
		$tokenContext = $this->getVal( self::FIELD_TOKEN_CTX, null );

		if ( empty( $userId ) || empty ( $token ) ) {
			return;
		}

		$user = \User::newFromId( $userId );
		if ( !$user instanceof \User ) {
			$this->response->setVal( self::FIELD_MESSAGE, self::ERR_USER_NOT_FOUND );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_NOT_FOUND );

			return;
		}

		if ( !\Sanitizer::validateEmail( $user->getEmail() ) ) {
			$this->response->setVal( self::FIELD_MESSAGE, self::ERR_INVALID_EMAIL );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_NOT_FOUND );

			return;
		}

		$emailController = ( $tokenContext === self::FACEBOOK_DISCONNECT_TOKEN_CONTEXT ) ?
			'Email\Controller\FacebookDisconnect' :
			'Email\Controller\PasswordResetLink';
		$resp = $this->app->sendRequest( $emailController, 'handle', [
			'targetUserId'          => $userId,
			self::FIELD_RESET_TOKEN => $token,
			self::FIELD_RETURN_URL  => $returnUrl,
		] );

		$data = $resp->getData();
		if ( !empty( $data[ self::FIELD_RESULT ] ) && $data[ self::FIELD_RESULT ] == 'ok' ) {
			$this->response->setVal( self::FIELD_SUCCESS, true );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_OK );
		} else {
			$this->response->setVal( self::FIELD_MESSAGE, self::ERR_COULD_NOT_SEND_AN_EMAIL_MESSAGE );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_NOT_FOUND );
		}
	}

	public function isBlocked() {
		$username = $this->getFieldFromRequest( self::FIELD_USERNAME, 'invalid username' );
		if ( !isset( $username ) ) {
			return;
		}

		$user = \User::newFromName( $username );
		if (
			!$user instanceof \User ||
			$user->getId() == 0
		) {
			$this->response->setVal( self::FIELD_MESSAGE, self::ERR_USER_NOT_FOUND );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_NOT_FOUND );

			return;
		}

		$this->response->setData( [ 'blocked' => $user->isBlocked() ] );
	}

	public function isDisabled() {
		$username = $this->getFieldFromRequest( self::FIELD_USERNAME, 'invalid username' );
		if ( !isset( $username ) ) {
			return;
		}

		$user = \User::newFromName( $username );
		if (
			!$user instanceof \User ||
			$user->getId() == 0
		) {
			$this->response->setVal( self::FIELD_MESSAGE, self::ERR_USER_NOT_FOUND );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_NOT_FOUND );

			return;
		}

		$this->response->setData( [ 'disabled' => ( bool )$user->getGlobalFlag( 'disabled', false ) ] );
	}

	public function logPiggybackAction() {
		$this->response->setVal( self::FIELD_SUCCESS, false );

		$performerUserId = $this->request->getInt( 'user_id' );
		$targetUserId = $this->request->getInt( 'target' );
		$login = $this->request->getCheck( 'login' ) && !$this->request->getCheck( 'logout' );

		if ( $performerUserId === 0 || $targetUserId === 0 ) {
			$this->response->setVal( self::FIELD_MESSAGE, self::ERR_INVALID_USER_ID );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		$performer = \User::newFromId( $performerUserId );
		$target = \User::newFromId( $targetUserId );

		if ( $login ) {
			\StaffLogger::eventlogPiggybackLogIn( $performer, $target );
		} else {
			\StaffLogger::eventlogPiggybackLogOut( $performer, $target );
		}

		$this->response->setVal( self::FIELD_SUCCESS, true );
		$this->response->setCode( \WikiaResponse::RESPONSE_CODE_OK );
	}

	private function getFieldFromRequest( $field, $failureMessage ) {
		$fieldValue = $this->getVal( $field, null );
		if ( !isset( $fieldValue ) ) {
			$this->response->setVal( self::FIELD_MESSAGE, $failureMessage );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
		}

		return $fieldValue;
	}

	private function authenticateViaTheSchwartz() {
		// There is an inconsistency between the parameter used for the Schwartz
		// token here and elsewhere in MediaWiki (e.g. LogEventsApi). Until we are
		// able to consolidate on the EXTERNAL_SCHWARTZ_PARAM both in MW and in
		// external clients, we need to support both.
		$ourSchwartz = $this->getVal( self::SCHWARTZ_PARAM, '' );
		$ourSchwartzIsValid = \hash_equals( $this->wg->TheSchwartzSecretToken, $ourSchwartz );

		$theirSchwartz = $this->getVal( self::EXTERNAL_SCHWARTZ_PARAM, '' );
		$theirSchwartzIsValid = \hash_equals( $this->wg->TheSchwartzSecretToken, $theirSchwartz );

		if ( $ourSchwartzIsValid || $theirSchwartzIsValid ) {
			return true;
		}

		return false;
	}
}
