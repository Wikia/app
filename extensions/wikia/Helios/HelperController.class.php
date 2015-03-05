<?php
namespace Wikia\Helios;

/**
 * A helper controller to provide end points exposing MediaWiki functionality to Helios.
 */
class HelperController extends \WikiaController
{
	/**
	 * AntiSpoof: verify whether the name is legal for a new account.
	 *
	 * @see extensions/AntiSpoof
	 */
	public function checkAntiSpoof()
	{
		$this->response->setFormat( 'json' );
		$this->response->setCacheValidity( \WikiaResponse::CACHE_DISABLED );

		if ( $this->getVal( 'secret' ) != $this->wg->TheSchwartzSecretToken ) {
			$this->response->setVal( 'allow', false );
			$this->response->setVal( 'message', 'invalid secret' );
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

		if ( $this->getVal( 'secret' ) != $this->wg->TheSchwartzSecretToken ) {
			$this->response->setVal( 'message', 'invalid secret' );
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

		if ( $this->getVal( 'secret' ) != $this->wg->TheSchwartzSecretToken ) {
			$this->response->setVal( 'message', 'invalid secret' );
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

		$mailTemplate = $this->app->renderView( 'UserLogin', 'GeneralMail', [ 'language' => $user->getOption( 'language' ), 'type' => 'confirmation-email' ] );
		$mailStatus = $user->sendConfirmationMail( false, 'ConfirmationMail', 'usersignup-confirmation-email', true, $mailTemplate );

		if ( ! $mailStatus->isGood() ) {
			$this->response->setVal( 'message', 'could not send an email message' );
			return;
		}

		$this->response->setVal( 'success', true );
	}
}
