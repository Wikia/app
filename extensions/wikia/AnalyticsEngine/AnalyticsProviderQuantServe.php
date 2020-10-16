<?php

class AnalyticsProviderQuantServe implements iAnalyticsProvider
{
	private $account = 'p-8bG6eLqkH6Avk';

	static function getQuantcastLabels() {
		$keyValues = F::app()->wg->DartCustomKeyValues;
		$quantcastLabels = array();
		$labels = array(
			'gnre' => 'Genre',
			'media' => 'Media',
			'theme' => 'Theme',
			'tv' => 'TV'
		);

		if (is_string($keyValues)) {
			foreach (explode(';', $keyValues) as $keyValue) {
				$keyValue = explode('=', $keyValue);
				$key = isset($keyValue[0]) ? $keyValue[0] : '';
				$value = isset($keyValue[1]) ? $keyValue[1] : '';

				if ($key && isset($labels[$key]) && $value) {
					$quantcastLabels[] = $labels[$key] . '.' . $value;
				}
			}
		}

		return join(',', $quantcastLabels);
	}

	function getSetupHtml($params = array())
	{
		static $called = false;
		if ($called == true) {
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

		trackingOptIn.pushToUserConsentQueue(function () {
			loadQuantServeScript();
		});
	});
</script>

EOT;
		return $tag;
	}

	function trackEvent($event, $eventDetails = array())
	{
		switch ($event) {
			case AnalyticsEngine::EVENT_PAGEVIEW:
				$quantcastLabels = self::getQuantcastLabels();

				return <<<EOT
<script type="text/javascript">
	_qevents.push( { qacct:"{$this->account}", labels:"{$quantcastLabels}" } );
</script>
EOT;
				break;
			default:
				return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}
}
