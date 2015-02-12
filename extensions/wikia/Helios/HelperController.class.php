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

		if ( $this->getVal( 'secret' ) != $this->wg->TheSchwartzSecretToken ) {
			return;
		}

		$sName = $this->getVal( 'username' );

		if ( !empty( $this->wg->EnableAntiSpoofExt ) ) {
			$oSpoofUser = new \SpoofUser( $sName );
			$oSpoofUser->record();
		}
	}
}
