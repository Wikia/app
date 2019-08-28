<?php

class WatchShowHooks {
	public static function onBeforePageDisplay(): bool {
		\Wikia::addAssetsToOutput( 'watch_show_scss' );
		\Wikia::addAssetsToOutput( 'watch_show_js' );

		return true;
	}

	public static function onMercuryWikiVariables( array &$wikiVariables ): bool {
		global $wgWatchShowURLMobile, $wgWatchShowButtonLabelMobile, $wgWatchShowURL, $wgWatchShowButtonLabel;

		if ( !empty( $wgWatchShowButtonLabelMobile ) ) {
			$wikiVariables['watchShowButtonLabel'] = $wgWatchShowButtonLabelMobile;
		} else if ( !empty( $wgWatchShowButtonLabel ) ) {
			$wikiVariables['watchShowButtonLabel'] = $wgWatchShowButtonLabel;
		} else {
			$wikiVariables['watchShowButtonLabel'] = 'Watch Now';
		}

		$wikiVariables['watchShowURL'] = !empty($wgWatchShowURLMobile) ? $wgWatchShowURLMobile : $wgWatchShowURL;

		return true;
	}

	public static function onGetRailModuleList( Array &$railModuleList ): bool {
		$railModuleList[1442] = [ 'WatchShowService', 'index', null ];

		return true;
	}
}
