<?php

class WatchShowHooks {
	public static function onBeforePageDisplay(): bool {
		\Wikia::addAssetsToOutput( 'watch_show_scss' );
		\Wikia::addAssetsToOutput( 'watch_show_js' );

		return true;
	}

	public static function onMercuryWikiVariables( array &$wikiVariables ): bool {
		global $wgWatchShowURLMobile, $wgWatchShowButtonLabelMobile, $wgWatchShowURL, $wgWatchShowButtonLabel;

		$wikiVariables['watchShowURL'] = $wgWatchShowURLMobile ?? $wgWatchShowURL ?? 'Watch This Show';
		$wikiVariables['watchShowButtonLabelMobile'] = $wgWatchShowButtonLabelMobile ?? 'Watch Now';

		return true;
	}

	public static function onGetRailModuleList( Array &$railModuleList ): bool {
		$railModuleList[1442] = [ 'WatchShowService', 'index', null ];

		return true;
	}
}
