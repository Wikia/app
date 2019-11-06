<?php

class WatchShowHooks {
	public static function onBeforePageDisplay(): bool {
		\Wikia::addAssetsToOutput( 'watch_show_scss' );
		\Wikia::addAssetsToOutput( 'watch_show_js' );

		return true;
	}

	public static function onMercuryWikiVariables( array &$wikiVariables ): bool {
		global $wgWatchShowURL,
		       $wgWatchShowURLMobile,
		       $wgWatchShowURLMobileAndroid,
		       $wgWatchShowGeos,
		       $wgWatchShowTrackingLabel,
		       $wgWatchShowEnabledDate,
		       $wgWatchShowButtonLabelMobile,
		       $wgWatchShowButtonLabelMobileCA,
		       $wgWatchShowImageURLMobile,
		       $wgWatchShowImageURLMobileDarkTheme,
		       $wgWatchShowCTAMobile,
		       $wgWatchShowCTAMobileCA,
		       $wgWatchShowTrackingPixelURL;

		if ( !empty( $wgWatchShowEnabledDate ) ) {
			$wikiVariables['watchShowEnabledDate'] = $wgWatchShowEnabledDate;
		}

		if ( !empty( $wgWatchShowURLMobileAndroid ) ) {
			$wikiVariables['watchShowURLAndroid'] = $wgWatchShowURLMobileAndroid;
			$wikiVariables['watchShowURLIOS'] = $wgWatchShowURLMobile;
		} else {
			$wikiVariables['watchShowURL'] = $wgWatchShowURL;
		}

		$wikiVariables['watchShowCTA'] = $wgWatchShowCTAMobile;
		if ( !empty( $wgWatchShowCTAMobileCA ) ) {
			$wikiVariables['watchShowCTACA'] = $wgWatchShowCTAMobileCA;
		}

		$wikiVariables['watchShowButtonLabel'] = $wgWatchShowButtonLabelMobile;
		if ( !empty( $wgWatchShowButtonLabelMobileCA ) ) {
			$wikiVariables['watchShowButtonLabelCA'] = $wgWatchShowButtonLabelMobileCA;
		}

		$wikiVariables['watchShowImageURL'] = $wgWatchShowImageURLMobile;

		if ( !empty( $wgWatchShowTrackingPixelURL ) ) {
			$wikiVariables['watchShowTrackingPixelURL'] = $wgWatchShowTrackingPixelURL;
		}

		if ( !empty( $wgWatchShowImageURLMobileDarkTheme ) ) {
			$wikiVariables['watchShowImageURLDarkTheme'] = $wgWatchShowImageURLMobileDarkTheme;
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

	/**
	 * Adds extra variables to the page config.
	 */
	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		global $wgWatchShowGeos, $wgWatchShowTrackingLabel, $wgWatchShowEnabledDate;

		$vars[ 'wgWatchShowEnabledDate' ] = $wgWatchShowEnabledDate;
		$vars[ 'wgWatchShowGeos' ] = $wgWatchShowGeos;
		$vars[ 'wgWatchShowTrackingLabel' ] = $wgWatchShowTrackingLabel;
		return true;
	}
}
