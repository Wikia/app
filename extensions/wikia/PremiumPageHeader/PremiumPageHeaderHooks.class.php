<?php

class PremiumPageHeaderHooks {
	public static function onBeforePageDisplay( /*\OutputPage $out, \Skin $skin */ ) {
		\Wikia::addAssetsToOutput( 'premium_page_header_scss' );
//		\Wikia::addAssetsToOutput( 'premium_page_header_js' );

		return true;
	}
}
