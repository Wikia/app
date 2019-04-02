<?php

class QualtricsSiteInterceptHooks {
	/**
	 * Add Qualtrics assets on Oasis
	 *
	 * @param  OutputPage $out  The OutputPage object
	 * @param  Skin       $skin The Skin object that will be used to render the page.
	 * @return boolean
	 */
	static public function onBeforePageDisplay( OutputPage $output, Skin $skin ): bool {
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) ) {
			$output->addModules( 'ext.wikia.QualtricsSiteIntercept' );
		}

		return true;
	}
}
