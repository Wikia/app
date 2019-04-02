<?php

class ResetTrackingPreferencesSpecialController extends WikiaSpecialPageController {

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	private $defaultReturnToTarget = 'https://www.fandom.com/privacy-policy';

	public function __construct() {
		parent::__construct( 'ResetTrackingPreferences' );
	}

	/**
	 * Main entry point.
	 */
	public function index() {
		$this->specialPage->setHeaders();

		$request = $this->getRequest();
		$output = $this->getOutput();

		$returnTo = $request->getVal( 'returnto' );
		if ( !empty( $returnTo ) && $this->isValidReturnToTarget( $returnTo ) ) {
			$this->setVal( 'returnToMsg', $this->msg( 'returnto', $returnTo )->parse() );
		} else {
			$this->setVal( 'returnToMsg', $this->msg( 'returnto', $this->defaultReturnToTarget )->parse() );
		}

		if ( $request->wasPosted() ) {
			$output->addModules( 'ext.wikia.resetTrackingSettings' );
		}

		// Just show the buttons
		$output->addModules( 'ext.wikia.resetTrackingSettingsManager' );
	}

	private function isValidReturnToTarget( $url ) {
		global $wgWikiaBaseDomainRegex;
		$host = parse_url( $url, PHP_URL_HOST );
		if ( $host === false || empty( $host ) ) {
			return false;
		}

		return preg_match( '/\\.' . $wgWikiaBaseDomainRegex . '$/', $host );
	}
}
