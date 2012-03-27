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
  var _qevents = _qevents || [];

  (function() {
   var elem = document.createElement('script');

   elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
   elem.async = true;
   elem.type = "text/javascript";
   var scpt = document.getElementsByTagName('script')[0];
   scpt.parentNode.insertBefore(elem, scpt);  
  })();
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
if (window.cityShort) {
	quantcastLabels += cityShort;
	if (window.wgDartCustomKeyValues) {
		var keyValues = wgDartCustomKeyValues.split(';');
		for (var i=0; i<keyValues.length; i++) {
			var keyValue = keyValues[i].split('=');
			if (keyValue.length >= 2) {
				quantcastLabels += ',' + cityShort + '.' + keyValue[1];
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
<noscript>
<div style="display: none;"><img src="//pixel.quantserve.com/pixel/{$this->account}.gif" height="1" width="1" alt="Quantcast"/></div>
</noscript>

EOT;
			return $tag;
			break;
		default:
			return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}
}
