<?php
namespace Wikia\Helios;

use Wikia\DependencyInjection\Injector;
use Wikia\Service\User\Auth\AuthService;

/**
 * A helper controller to provide end points exposing MediaWiki functionality to Helios.
 */
class HelperController extends \WikiaController
{

	protected $authService;


	/**
	 * AntiSpoof: verify whether the name is legal for a new account.
	 *
	 * @see extensions/AntiSpoof
	 */
	public function checkAntiSpoof()
	{
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
		$this->response->setVal( 'allow', $spoofUser->isLegal() && ! $spoofUser->getConflicts() );
		return;
	}

	/**
	 * AntiSpoof: update records once a new account has been created.
	 *
	 * @see extensions/AntiSpoof
	 */
	public function updateAntiSpoof()
	{
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
	public function sendConfirmationEmail()
	{
		$this->response->setFormat( 'json' );
		$this->response->setCacheValidity( \WikiaResponse::CACHE_DISABLED );
		$this->response->setVal( 'success', false );

		if ( !$this->authenticateViaTheSchwartz() ) {
			return;
		}

		if ( ! $this->wg->EmailAuthentication ) {
			$this->response->setVal( 'message', 'email authentication is not required' );
			return;
		}

		$username = $this->getVal( 'username' );

		wfWaitForSlaves( $this->wg->ExternalSharedDB );
		$user = \User::newFromName( $username );

		if ( ! $user instanceof \User ) {
			$this->response->setVal( 'message', 'unable to create a \User object from name' );
			return;
		}

		if ( ! $user->getId() ) {
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

		$mailStatus = $user->sendConfirmationMail();

		if ( ! $mailStatus->isGood() ) {
			$this->response->setVal( 'message', 'could not send an email message' );
			return;
		}

		$this->response->setVal( 'success', true );
	}

	public function isBlocked() {
		if ( !$this->authenticateViaTheSchwartz() ) {
			return;
		}

		$username = $this->getFieldFromRequest( 'username', 'invalid username' );
		if ( !isset( $username ) ) {
			return;
		}

		$blocked = $this->getAuthService()->isUsernameBlocked( $username );
		if ( $blocked === null ) {
			$this->response->setVal( 'message', 'user not found' );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_NOT_FOUND );
			return;
		}

		$this->response->setData( array( 'blocked' => $blocked ) );
	}

	protected function getFieldFromRequest( $field, $failureMessage ) {
		$username = $this->getVal( 'username', null );
		if ( !isset( $username ) ) {
			$this->response->setVal( 'message', $failureMessage );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
		}

		return $username;
	}

	protected function authenticateViaTheSchwartz() {
		if ( $this->getVal( 'secret' ) != $this->wg->TheSchwartzSecretToken ) {
			$this->response->setVal( 'message', 'invalid secret' );
			$this->response->setCode( \WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return false;
		}

		return true;
	}

	public function setAuthService( AuthService $authService ) {
		$this->authService = $authService;
	}

	public function getAuthService() {
		if (!isset($this->authService)) {
			$this->authService = Injector::getInjector()->get(AuthService::class);
		}

		return $this->authService;
	}

}
