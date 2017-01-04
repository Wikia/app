<?php

class EmailConfirmationHooks {

	/**
	 * Add JS messages to the output
	 * @param \OutputPage $out An output object passed from a hook
	 * @return bool
	 */
	public static function onBeforePageDisplay( \OutputPage $out ) {
		Wikia::addAssetsToOutput( 'email_confirmation_banner_js' );
		JSMessages::enqueuePackage('EmailConfirmationBanner', JSMessages::EXTERNAL);

		return true;
	}
}

