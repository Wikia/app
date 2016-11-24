<?php
class RWEPageHeaderHooks {
	public static function onBeforePageDisplay( $out, $skin ) {
		\Wikia::addAssetsToOutput( 'RWEPageHeader_scss' );
		\Wikia::addAssetsToOutput( 'RWEPageHeader_js' );
		return true;
	}
}