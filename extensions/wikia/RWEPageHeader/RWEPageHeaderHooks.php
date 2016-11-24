<?php
class RWEPageHeaderHooks {
	public static function onBeforePageDisplay( $out, $skin ) {
		\Wikia::addAssetsToOutput( 'RWEPageHeader_scss' );

		return true;
	}
}