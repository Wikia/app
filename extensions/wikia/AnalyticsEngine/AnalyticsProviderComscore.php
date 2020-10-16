<?php

class AnalyticsProviderComscore implements iAnalyticsProvider {

	private static $COMSCORE_KEYWORD_KEYNAME = 'comscorekw';
	private static $PARTNER_ID = 6177433;

	function getSetupHtml($params=array()){
		return null;
	}

	function trackEvent($event, $eventDetails=array()){
		switch ($event){
		  case AnalyticsEngine::EVENT_PAGEVIEW :
			  if (static::getC7Value()) {
					return '
<!-- Begin comScore Tag -->
<script type="text/javascript">
require(["wikia.trackingOptIn"], function (trackingOptIn) {
	function loadComscoreScript() {
		window._comscore = window._comscore || [];
		window._comscore.push({ c1: "2", c2: "' . static::$PARTNER_ID . '",
			options: {
				url_append: "' . static::$COMSCORE_KEYWORD_KEYNAME . '=' . static::getC7Value() . '"
			}
		});
	
		var s = document.createElement("script");
		s.async = true;
		s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
		document.head.appendChild(s);
	}

	trackingOptIn.pushToUserConsentQueue(function () {
		loadComscoreScript();
	});
});
</script>
<!-- End comScore Tag -->';
			}
			break;
			default: return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

	public static function getC7Value() {
		global $wgCityId;

		$verticalName = HubService::getVerticalNameForComscore( $wgCityId );

		$categoryOverride = HubService::getComscoreCategoryOverride( $wgCityId );
		if ( $categoryOverride ) {
			$verticalName = $categoryOverride;
		}

		if ( !$verticalName ) {
			\Wikia\Logger\WikiaLogger::instance()->error( 'Vertical not set for comscore', [
				'cityId' => $wgCityId,
				'exception' => new Exception()
			] );
			return false;
		} else {
			return 'wikiacsid_' . $verticalName;
		}
	}
}
