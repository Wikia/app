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

		$sName = $this->getVal( 'username' );

		// Allow the given user name if the AntiSpoof extension is disabled.
		if ( empty( $this->wg->EnableAntiSpoofExt ) ) {
			return $this->response->setVal( 'allow', true );
		}

		$oSpoofUser = new \SpoofUser( $sName );
		$aConflicts = $oSpoofUser->getConflicts();

		// Allow the given user name if it is legal and does not conflict with other names.
		return $this->response->setVal( 'allow', $oSpoofUser->isLegal() && ! $oSpoofUser->getConflicts() );
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

		$sName = $this->getVal( 'username' );

		if ( !empty( $this->wg->EnableAntiSpoofExt ) ) {
			$oSpoofUser = new \SpoofUser( $sName );
			return $this->response->setVal( 'success', $oSpoofUser->record() );
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

		$sName = $this->getVal( 'username' );

		$this->wf->WaitForSlaves( $this->wg->ExternalSharedDB );
		$oUser = \User::newFromName( $sName );

		if ( ! $oUser instanceof \User ) {
			$this->response->setVal( 'message', 'unable to create a \User object from name' );
			return;
		}

		if ( ! $oUser->getId() ) {
			$this->response->setVal( 'message', 'no such user' );
			return;
		}

		if ( $oUser->isEmailConfirmed() ) {
			$this->response->setVal( 'message', 'already confirmed' );
			return;
		}

		$oUserLoginHelper = ( new \UserLoginHelper );
		$sMemKey = $oUserLoginHelper->getMemKeyConfirmationEmailsSent( $oUser->getId() );
		$iEmailSent = intval( $this->wg->Memc->get( $sMemKey ) );

		if ( $oUser->isEmailConfirmationPending() &&
			strtotime( $oUser->mEmailTokenExpires ) - strtotime( '+6 days' ) > 0 &&
			$iEmailSent >= \UserLoginHelper::LIMIT_EMAILS_SENT
		) {
			$this->response->setVal( 'message', 'confirmation emails limit reached' );
			return;
		}

		if ( ! \Sanitizer::validateEmail( $oUser->getEmail() ) ) {
			$this->response->setVal( 'message', 'invalid email' );
			return;
		}

		$sTemplate = $this->app->renderView( 'UserLogin', 'GeneralMail', [ 'language' => $oUser->getOption( 'language' ), 'type' => 'confirmation-email' ] );
		$oResponse = $oUser->sendConfirmationMail( false, 'ConfirmationMail', 'usersignup-confirmation-email', true, $sTemplate );

		if ( ! $oResponse->isGood() ) {
			$this->response->setVal( 'message', 'could not send an email message' );
			return;
		}

		$this->response->setVal( 'success', true );
	}
}
