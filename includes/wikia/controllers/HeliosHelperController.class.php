<?php

namespace Wikia\Helios;

use Email\Controller\EmailConfirmationController;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\User\Auth\AuthService;

/**
 * A helper controller to provide end points exposing MediaWiki functionality to Helios.
 */
class HelperController extends \WikiaController {
	const SCHWARTZ_PARAM = 'secret';
	const EXTERNAL_SCHWARTZ_PARAM = 'token';

	/**
	 * AntiSpoof: verify whether the name is legal for a new account.
	 *
	 * @see extensions/AntiSpoof
	 */
	public function checkAntiSpoof() {
		$this->response->setFormat( 'json' );
		$this->response->setCacheValidity( \WikiaResponse::CACHE_DISABLED );

		if ( !$this->authenticateViaTheSchwartz() ) {
			$this->response->setVal( 'allow', false );
			return;
		}

		$username = $this->getVal( 'username' );

		// Allow the given user name if the AntiSpoof extension is disabled.
		if ( empty( $this->wg->EnableAntiSpoofExt ) ) {
			$this->response->setVal( 'allow', true );
			return;
		}

		$spoofUser = new \SpoofUser( $username );

		// Allow the given user name if it is legal and does not conflict with other names.
		$this->response->setVal( 'allow', $spoofUser->isLegal() && !$spoofUser->getConflicts( true ) );
		return;
	}

	/**
	 * AntiSpoof: update records once a new account has been created.
	 *
	 * @see extensions/AntiSpoof
	 */
	public function updateAntiSpoof() {
		$this->response->setFormat( 'json' );
		$this->response->setCacheValidity( \WikiaResponse::CACHE_DISABLED );
		$this->response->setVal( 'success', false );

		if ( !$this->authenticateViaTheSchwartz() ) {
			return;
		}

		$username = $this->getVal( 'username' );

		if ( !empty( $this->wg->EnableAntiSpoofExt ) ) {
			$spoofUser = new \SpoofUser( $username );
			$this->response->setVal( 'success', $spoofUser->record() );
			return;
		}
	}

	/**
	 * UserLogin: send a confirmation email a new account has been created
	 */
	public function sendConfirmationEmail() {
		$this->response->setFormat( 'json' );
		$this->response->setCacheValidity( \WikiaResponse::CACHE_DISABLED );
		$this->response->setVal( 'success', false );

		if ( !$this->authenticateViaTheSchwartz() ) {
			return;
		}

		if ( !$this->wg->EmailAuthentication ) {
			$this->response->setVal( 'message', 'email authentication is not required' );
			return;
		}

		$username = $this->getVal( 'username' );

		wfWaitForSlaves( $this->wg->ExternalSharedDB );
		$user = \User::newFromName( $username );

		if ( !$user instanceof \User ) {
			$this->response->setVal( 'message', 'unable to create a \User object from name' );
			return;
		}

		if ( !$user->getId() ) {
			$this->response->setVal( 'message', 'no such user' );
			return;
		}

		if ( $user->isEmailConfirmed() ) {
			$this->response->setVal( 'message', 'already confirmed' );
			return;
		}

		$userLoginHelper = ( new \UserLoginHelper );
		$memcKey = $userLoginHelper->getMemKeyConfirmationEmailsSent( $user->getId() );
		$emailsSent = intval( $this->wg->Memc->get( $memcKey ) );

		if ( $user->isEmailConfirmationPending() &&
			strtotime( $user->mEmailTokenExpires ) - strtotime( '+6 days' ) > 0 &&
			$emailsSent >= \UserLoginHelper::LIMIT_EMAILS_SENT
		) {
			$this->response->setVal( 'message', 'confirmation emails limit reached' );
			return;
		}

		if ( ! \Sanitizer::validateEmail( $user->getEmail() ) ) {
			$this->response->setVal( 'message', 'invalid email' );
			return;
		}

		$mailStatus = $user->sendConfirmationMail(
			'created', EmailConfirmationController::TYPE, '', true, '', $this->getVal( 'langCode', 'en' ));

		if ( ! $mailStatus->isGood() ) {
			$this->response->setVal( 'message', 'could not send an email message' );
			return;
		}

		$this->response->setVal( 'success', true );
	}

	/**
	 * UserLogin: send an email with temporary password
	 */
	public function sendTemporaryPasswordEmail() {
		$this->response->setFormat( 'json' );
		$this->response->setCacheValidity( \WikiaResponse::CACHE_DISABLED );
		$this->response->setVal( 'success', false );

		if ( !$this->authenticateViaTheSchwartz() ) {
			return;
		}

		$username = $this->getFieldFromRequest( 'username', 'invalid username' );
		if ( !isset( $username ) ) {
			return;
		}

		$tempPassword = $this->getFieldFromRequest( 'password', 'invalid password' );
		if ( !isset( $tempPassword ) ) {
			return;
		}

		$user = \User::newFromName( $username );

		if ( ! $user instanceof \User ) {
			$this->response->setVal( 'message', 'unable to create a \User object from name' );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		if ( ! $user->getId() ) {
			$this->response->setVal( 'message', 'no such user' );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		$resp = \F::app()->sendRequest( 'Email\Controller\ForgotPassword', 'handle', [
			'targetUser' => $username,
			'tempPass' => $tempPassword,
		] );

		$data = $resp->getData();
		if ( !empty( $data['result'] ) && $data['result'] == 'ok' ) {
			$this->response->setVal( 'success', true );
		} else {
			$this->response->setVal( 'message', 'could not send an email message' );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_NOT_FOUND );
		}
	}

	public function isBlocked() {
		$this->response->setFormat( 'json' );
		$this->response->setCacheValidity( \WikiaResponse::CACHE_DISABLED );

		if ( !$this->authenticateViaTheSchwartz() ) {
			return;
		}

		$username = $this->getFieldFromRequest( 'username', 'invalid username' );
		if ( !isset( $username ) ) {
			return;
		}

		$user = \User::newFromName( $username );
		if (
			!$user instanceof User ||
			$user->getId() == 0
		) {
			$this->response->setVal( 'message', 'user not found' );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_NOT_FOUND );
			return;
		}

		$this->response->setData( [ 'blocked' => $user->isBlocked() ] );
	}

	private function getFieldFromRequest( $field, $failureMessage ) {
		$fieldValue = $this->getVal( $field, null );
		if ( !isset( $fieldValue ) ) {
			$this->response->setVal( 'message', $failureMessage );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
		}

		return $fieldValue;
	}

	private function authenticateViaTheSchwartz() {
		// There is an inconsistency between the parameter used for the Schwartz
		// token here and elsewhere in MediaWiki (e.g. LogEventsApi). Until we are
		// able to consolidate on the EXTERNAL_SCHWARTZ_PARAM both in MW and in
		// external clients, we need to support both.
		$ourSchwartz          = $this->getVal( self::SCHWARTZ_PARAM, '' );
		$ourSchwartzIsValid   = \hash_equals( $this->wg->TheSchwartzSecretToken, $ourSchwartz );

		$theirSchwartz        = $this->getVal( self::EXTERNAL_SCHWARTZ_PARAM, '' );
		$theirSchwartzIsValid = \hash_equals( $this->wg->TheSchwartzSecretToken, $theirSchwartz );

		if ( $ourSchwartzIsValid || $theirSchwartzIsValid ) {
			return true;
		}

		$this->response->setVal( 'message', 'invalid secret' );
		$this->response->setCode( \WikiaResponse::RESPONSE_CODE_FORBIDDEN );
		return false;
	}
}
