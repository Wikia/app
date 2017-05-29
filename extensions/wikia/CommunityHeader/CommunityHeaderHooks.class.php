<?php

class CommunityHeaderHooks {
	public static function onBeforePageDisplay( /*\OutputPage $out, \Skin $skin */ ) {
		\Wikia::addAssetsToOutput( 'community_header_scss' );
		\Wikia::addAssetsToOutput( 'community_header_js' );

		return true;
	}
}
