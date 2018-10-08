<?php

class ResetTrackingPreferencesSpecialController extends WikiaSpecialPageController {

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

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

		// CSRF protection
		if ( $request->wasPosted()
			&& $this->getUser()->matchEditToken( $request->getVal( 'token' ) )
		) {
			$output->addModules( 'ext.wikia.resetTrackingSettings' );
		} else {
			// Just show the button
			$output->addModules( 'ext.wikia.trackingSettingsManager' );
		}
	}
}
