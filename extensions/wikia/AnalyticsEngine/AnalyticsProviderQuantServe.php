<?php

class AnalyticsProviderQuantServe implements iAnalyticsProvider {

	private $account = 'p-8bG6eLqkH6Avk';

	function getSetupHtml($params=array()){
		static $called = false;
		if ($called == true){
			return '';
		} else {
			$called = true;
		}

		$tag = <<<EOT
<script type="text/javascript">
window._qevents = window._qevents || [];
require(["wikia.trackingOptIn"], function (trackingOptIn) {
	function loadQuantServeScript() {
		var elem = document.createElement('script');
		
		elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
		elem.async = true;
		elem.type = "text/javascript";
		
		document.head.appendChild(elem);
	}

	trackingOptIn.pushToUserConsentQueue(function (optIn) {
		if (optIn) {
			loadQuantServeScript();
		}
	});
});
</script>

EOT;
		return $tag;
	}

	function trackEvent($event, $eventDetails=array()){
		switch ($event){
			case AnalyticsEngine::EVENT_PAGEVIEW:
				$extraLabels = !empty($eventDetails['extraLabels']) ? ','.implode(',', $eventDetails['extraLabels']) : '';
				$tag = <<<EOT
<script type="text/javascript">
var quantcastLabels = "";
if (window.wgWikiVertical) {
	quantcastLabels += wgWikiVertical;
	if (window.wgDartCustomKeyValues) {
		var keyValues = wgDartCustomKeyValues.split(';');
		for (var i=0; i<keyValues.length; i++) {
			var keyValue = keyValues[i].split('=');
			if (keyValue.length >= 2) {
				quantcastLabels += ',' + wgWikiVertical + '.' + keyValue[1];
			}
		}
	}
}

EOT;
				if ($extraLabels) {
					$tag .= "quantcastLabels += '$extraLabels'\n";
				}
				$tag .= <<<EOT
_qevents.push( { qacct:"{$this->account}", labels:quantcastLabels } );
</script>
EOT;
			return $tag;
			break;
		default:
			return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}
}
