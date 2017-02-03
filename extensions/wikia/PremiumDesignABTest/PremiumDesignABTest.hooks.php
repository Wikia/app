<?php
class PremiumDesignABTestHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'premium_design_ab_test_scss' );
		\Wikia::addAssetsToOutput( 'premium_design_ab_test_js' );

		// TODO: add js for certain option (A/B/C)
		\Wikia::addAssetsToOutput( 'premium_design_ab_test_js_A' );


		return true;
	}
}