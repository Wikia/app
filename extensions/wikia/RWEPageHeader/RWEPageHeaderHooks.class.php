<?php

class RWEPageHeaderHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'rwe_page_header_scss' );

		return true;
	}
}
