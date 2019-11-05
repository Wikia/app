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
		       $wgWatchShowURLMobileAndroid,
		       $wgWatchShowURL,
					 $wgWatchShowGeos,
					 $wgWatchShowTrackingLabel,
		       $wgWatchShowEnabledDate,
		       $wgWatchShowButtonLabel,
		       $wgWatchShowImageURL,
		       $wgWatchShowImageURLMobile,
		       $wgWatchShowImageURLMobileDarkTheme,
		       $wgWatchShowCTA,
		       $wgWatchShowCTAMobile,
		       $wgWatchShowTrackingPixelURL;

		if ( !empty( $wgWatchShowURLMobileAndroid ) ) {
			$wikiVariables['watchShowURLAndroid'] = $wgWatchShowURLMobileAndroid;
			$wikiVariables['watchShowURLIOS'] = $wgWatchShowURLMobile;
		} else {
			$wikiVariables['watchShowURL'] = !empty( $wgWatchShowURLMobile ) ? $wgWatchShowURLMobile : $wgWatchShowURL;
		}

		$wikiVariables['watchShowCTA'] = !empty( $wgWatchShowCTAMobile ) ? $wgWatchShowCTAMobile : $wgWatchShowCTA;
		$wikiVariables['watchShowButtonLabel'] =
			!empty( $wgWatchShowButtonLabelMobile ) ? $wgWatchShowButtonLabelMobile : $wgWatchShowButtonLabel;
		$wikiVariables['watchShowImageURL'] =
			!empty( $wgWatchShowImageURLMobile ) ? $wgWatchShowImageURLMobile : $wgWatchShowImageURL;

		if ( !empty( $wgWatchShowTrackingPixelURL ) ) {
			$wikiVariables['watchShowTrackingPixelURL'] = $wgWatchShowTrackingPixelURL;
		}

		if ( !empty( $wgWatchShowImageURLMobileDarkTheme ) ) {
			$wikiVariables['watchShowImageURLDarkTheme'] = $wgWatchShowImageURLMobileDarkTheme;
		}

		if ( !empty( $wgWatchShowEnabledDate ) ) {
			$wikiVariables['watchShowEnabledDate'] = $wgWatchShowEnabledDate;
		}

		if ( !empty( $wgWatchShowGeos ) ) {
			$wikiVariables['watchShowGeos'] = $wgWatchShowGeos;
		}

		if ( !empty( $wgWatchShowTrackingLabel ) ) {
			$wikiVariables['watchShowTrackingLabel'] = $wgWatchShowTrackingLabel;

		}

		return true;
	}

	public static function onGetRailModuleList( Array &$railModuleList ): bool {
		$railModuleList[1442] = [ 'WatchShowService', 'index', null ];

		return true;
	}
}
