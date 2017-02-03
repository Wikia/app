<?php
class PremiumDesignABTestHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		global $wgPremiumDesignABTestVariants;

		$app = F::app();
		$articleId = $app->wg->Title->getArticleID();

		\Wikia::addAssetsToOutput( 'premium_design_ab_test_scss' );
		\Wikia::addAssetsToOutput( 'premium_design_ab_test_js' );

		if ( array_key_exists( $articleId, $wgPremiumDesignABTestVariants ) ) {
			\Wikia::addAssetsToOutput( 'premium_design_ab_test_js_' . $wgPremiumDesignABTestVariants[$articleId]['letter'] );
		}


		return true;
	}
}
