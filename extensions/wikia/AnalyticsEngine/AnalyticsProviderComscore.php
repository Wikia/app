<?php

class AnalyticsProviderComscore implements iAnalyticsProvider {
	
	private static $COMSCORE_KEYWORD_KEYNAME = 'comscorekw';
	private static $PARTNER_ID = 6177433;

	function getSetupHtml($params=array()){
		return null;
	}

	function trackEvent($event, $eventDetails=array()){
		switch ($event){
		  case AnalyticsEngine::EVENT_PAGEVIEW : return '
<!-- Begin comScore Tag -->
<script type="text/javascript">
var _comscore = _comscore || [];
_comscore.push({ c1: "2", c2: "'.self::$PARTNER_ID.'",
	options: {
		url_append: "'.self::$COMSCORE_KEYWORD_KEYNAME.'='.$this->getC7Value().'"
	}
});

(function() {
	var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;
	s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
	el.parentNode.insertBefore(s, el);
})();
</script>
<noscript>
<img src="http://b.scorecardresearch.com/p?c1=2&amp;c2='.self::$PARTNER_ID.'&amp;c3=&amp;c4=&amp;c5=&amp;c6=&amp;c7='.$this->getC7ParamAndValue().'&amp;c15=&amp;cv=2.0&amp;cj=1" />
</noscript>
<!-- End comScore Tag -->';
			break;
                  default: return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

	private function getC7Value() {
		global $wgCityId;

		$catInfo = HubService::getCategoryInfoForCity($wgCityId);

		return 'wikiacsid_' . strtolower($catInfo->cat_name);
	}
	
	private function getC7ParamAndValue() {
		global $wgRequest;
		
		$requestUrl = $wgRequest->getFullRequestURL();
		$paramAndValue = $requestUrl . (strpos($requestUrl, '?') !== FALSE ? '&' : '?') . self::$COMSCORE_KEYWORD_KEYNAME . '=' . $this->getC7Value();		
		return urlencode($paramAndValue);
	}
}
