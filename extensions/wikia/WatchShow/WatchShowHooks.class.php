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
		       $wgWatchShowButtonLabelCA,
		       $wgWatchShowImageURL,
		       $wgWatchShowImageURLMobile,
		       $wgWatchShowImageURLMobileDarkTheme,
		       $wgWatchShowCTA,
		       $wgWatchShowCTACA,
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

		if ( !empty( $wgWatchShowCTACA ) ) {
			$wikiVariables['watchShowCTACA'] = $wgWatchShowCTACA;
		}

		if ( !empty( $wgWatchShowButtonLabelCA ) ) {
			$wikiVariables['watchShowButtonLabelCA'] = $wgWatchShowButtonLabelCA;
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
