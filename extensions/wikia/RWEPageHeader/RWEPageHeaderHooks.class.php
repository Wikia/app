<?php

class RWEPageHeaderHooks {
	public static function onBeforePageDisplay( /*\OutputPage $out, \Skin $skin */ ) {
		\Wikia::addAssetsToOutput( 'rwe_page_header_scss' );
		\Wikia::addAssetsToOutput( 'rwe_page_header_js' );

		return true;
	}
}
