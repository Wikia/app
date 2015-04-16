<?php

class InsightsHooks {

	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		global $wgRequest;

		if ( $wgRequest->getInt('insights', 0) ) {
			$out->addScriptFile('/extensions/wikia/Insights/scripts/insightsTracking.js');
		}

		return true;
	}

	public static function onArticleUpdateBeforeRedirect( $article, &$sectionanchor, &$extraQuery ) {
		global $wgRequest;

		$inInsightsFlow = $wgRequest->getVal('insights', 0);

		if ( $inInsightsFlow ) {
			if ( !empty( $extraQuery ) ) {
				$extraQuery .= '&';
			}
			$extraQuery .= 'insights=1';
		}

		return true;
	}

	public static function onGetLocalURL( &$this, &$url, $query ) {
		global $wgRequest;

		$inInsightsFlow = $wgRequest->getInt('insights', 0);

		if ( $inInsightsFlow ) {
			$action = $wgRequest->getVal( 'action', 'view' );
			if ( $action == 'edit'  && $query == 'action=submit' ) {
				$url .= '&insights=1';
			}
		}

		return true;
	}
} 
