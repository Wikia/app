<?php

class PremiumPageHeaderHooks {
	public static function onBeforePageDisplay( /*\OutputPage $out, \Skin $skin */ ) {
		global $wgEnableCuratedContentExt;
		OasisController::addBodyClass( 'pph-experiment' );

		if ( !empty( $wgEnableCuratedContentExt ) && CuratedContentHelper::shouldDisplayToolButton() ) {
			\Wikia::addAssetsToOutput( 'premium_page_header_curated_content_js' );
		}
		\Wikia::addAssetsToOutput( 'premium_page_header_scss' );
		\Wikia::addAssetsToOutput( 'premium_page_header_js' );

		return true;
	}
}
