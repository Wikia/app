<?php

class AnalyticsProviderIVW3 implements iAnalyticsProvider {

	private static $libraryUrl = 'https://script.ioam.de/iam.js';

	static public function onInstantGlobalsGetVariables( array &$vars )
	{
		$vars[] = 'wgAnalyticsIVW3Countries';

		return true;
	}

	function getSetupHtml( $params = array() ) {
		return null;
	}

	function trackEvent( $event, $eventDetails = array() ) {
		global $wgCityId;

		$url = self::$libraryUrl;
		$vertical = HubService::getVerticalNameForComscore( $wgCityId );

		$code = <<<CODE
<script type="text/javascript" src="{$url}"></script>
<script type="text/javascript">
	require([
		"wikia.geo",
		"wikia.instantGlobals"
	], function (geo, instantGlobals) {
		var iamData = {
			st: 'wikia',
			cp: '{$vertical}',
			sv: 'ke'
		};

		if (geo.isProperGeo(instantGlobals.wgAnalyticsIVW3Countries)) {
			iom.c(iamData);
		};
	});
</script>
CODE;

		switch ($event) {
			case AnalyticsEngine::EVENT_PAGEVIEW:
				return $code;
			default:
				return '<!-- Unsupported event for IVW3 -->';
		}
	}
}
