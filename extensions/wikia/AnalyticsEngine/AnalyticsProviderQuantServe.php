<?php

class AnalyticsProviderQuantServe implements iAnalyticsProvider {

	private $account = 'p-8bG6eLqkH6Avk';

	function getSetupHtml(){
		global $wgProto;

		static $called = false;
		if ($called == true){
			return '';
		} else {
			$called = true;
		}

		return  '<script type="text/javascript" src="' . $wgProto . '://edge.quantserve.com/quant.js"></script>' . "\n" .
			"<script type=\"text/javascript\">/*<![CDATA[*/
			try {
				_qoptions = { qacct: '{$this->account}' };
				if (cityShort != 'undefined' && cityShort) {
					_qoptions.labels = cityShort;
					if (wgDartCustomKeyValues != 'undefined' && wgDartCustomKeyValues) {
						var keyValues = wgDartCustomKeyValues.split(';');
						for (var i=0; i<keyValues.length; i++) {
							var keyValue = keyValues[i].split('=');
							if (keyValue.length >= 2) {
								_qoptions.labels += ',' + cityShort + '.' + keyValue[1];
							}
						}
					}
				}
			} catch (e){
				// Fall back to old way.
				_qacct=\"{$this->account}\";
			}
			/*]]>*/</script>";
	}

	function trackEvent($event, $eventDetails=array()){
		switch ($event){
		  case AnalyticsEngine::EVENT_PAGEVIEW : return '<script type="text/javascript">if (typeof quantserve == "function") quantserve();</script>';
                  default: return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}


}
