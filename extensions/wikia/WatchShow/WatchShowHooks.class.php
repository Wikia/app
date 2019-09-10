<?php

class WatchShowHooks {
	public static function onBeforePageDisplay(): bool {
		\Wikia::addAssetsToOutput( 'watch_show_scss' );
		\Wikia::addAssetsToOutput( 'watch_show_js' );

		return true;
	}

	public static function onMercuryWikiVariables( array &$wikiVariables ): bool {
		global $wgWatchShowURLMobile,
		       $wgWatchShowButtonLabelMobile,
		       $wgWatchShowURL,
		       $wgWatchShowButtonLabel,
		       $wgWatchShowImageURL,
		       $wgWatchShowCTA,
		       $wgWatchShowCTAMobile,
		       $wgWatchShowTrackingPixelURL;

		$wikiVariables['watchShowURL'] = !empty( $wgWatchShowURLMobile ) ? $wgWatchShowURLMobile : $wgWatchShowURL;
		$wikiVariables['watchShowCTA'] = !empty( $wgWatchShowCTAMobile ) ? $wgWatchShowCTAMobile : $wgWatchShowCTA;
		$wikiVariables['watchShowButtonLabel'] =
			!empty( $wgWatchShowButtonLabelMobile ) ? $wgWatchShowButtonLabelMobile : $wgWatchShowButtonLabel;
		$wikiVariables['watchShowImageURL'] = $wgWatchShowImageURL;
		$wikiVariables['watchShowTrackingPixelURL'] = $wgWatchShowTrackingPixelURL;

		return true;
	}

	public static function onGetRailModuleList( Array &$railModuleList ): bool {
		$railModuleList[1442] = [ 'WatchShowService', 'index', null ];

		return true;
	}
}
