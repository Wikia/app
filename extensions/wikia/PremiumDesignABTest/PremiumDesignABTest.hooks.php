<?php
class PremiumDesignABTestHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'premium_design_ab_test_scss' );

		return true;
	}
}