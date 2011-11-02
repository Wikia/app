<?php

class AnalyticsProviderQuantServe implements iAnalyticsProvider {

	private $account = 'p-8bG6eLqkH6Avk';

	function getSetupHtml($params=array()){
		global $wgProto;

		static $called = false;
		if ($called == true){
			return '';
		} else {
			$called = true;
		}

		$hostPrefix = ($wgProto == 'https') ? 'https://secure' : 'http://edge';

		$extraLabels = !empty($params['extraLabels']) ? ','.implode(',', $params['extraLabels']) : '';
		
		return  '<script type="text/javascript" src="' . $hostPrefix . '.quantserve.com/quant.js"></script>' . "\n" .
			"<script type=\"text/javascript\">/*<![CDATA[*/
			try {
				_qoptions = { qacct: '{$this->account}' };
				if (cityShort != 'undefined' && cityShort) {
					_qoptions.labels = cityShort;
					if (window.wgDartCustomKeyValues) {
						var keyValues = wgDartCustomKeyValues.split(';');
						for (var i=0; i<keyValues.length; i++) {
							var keyValue = keyValues[i].split('=');
							if (keyValue.length >= 2) {
								_qoptions.labels += ',' + cityShort + '.' + keyValue[1];
							}
						}
					}
					_qoptions.labels += '".$extraLabels."';
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
