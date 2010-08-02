<?php

class AnalyticsProviderExelate implements iAnalyticsProvider {
	function getSetupHtml() {
		return null;
	}

	function trackEvent($event, $eventDetails = array()) {
		switch ($event){
			case AnalyticsEngine::EVENT_PAGEVIEW:
				global $wgExelateData;
				if (empty($wgExelateData) || !is_array($wgExelateData) || empty($wgExelateData["c"])) return "";

				$payload = "";
				foreach ($wgExelateData as $key => $val) {
					$payload .= "&" . urlencode($key) . "=" . urlencode($val);
				}

				return "<script type=\"text/javascript\" src=\"http://loadus.exelator.com/load/?p=232&g=001{$payload}\"></script>\n";

				break;
			default:
				return "<!-- Unsupported event for " . __CLASS__ . " -->";
		}
	}
}
