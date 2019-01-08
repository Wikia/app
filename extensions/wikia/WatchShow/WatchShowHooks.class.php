<?php

class WatchShowHooks {
	public static function onBeforePageDisplay() {
		\Wikia::addAssetsToOutput( 'watch_show_scss' );
		\Wikia::addAssetsToOutput( 'watch_show_js' );

		return true;
	}

	public static function onMercuryWikiVariables( array &$wikiVariables ): bool {
		global $wgWatchShowURL;

		if ( !empty( $wgWatchShowURL ) ) {
			$wikiVariables['watchShowURL'] = $wgWatchShowURL;
		}

		return true;
	}
}
