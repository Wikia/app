<?php

class AnalyticsProviderIVW3 implements iAnalyticsProvider {

	private static $instantGlobalsVariable = 'wgAnalyticsIVW3Countries';
	private static $libraryUrl = 'https://script.ioam.de/iam.js';

	static public function onInstantGlobalsGetVariables( array &$vars )
	{
		$vars[] = self::$instantGlobalsVariable;

		return true;
	}

	function getSetupHtml( $params = array() ) {
		return null;
	}

	function trackEvent( $event, $eventDetails = array() ) {
		global $wgCityId;

		$url = self::$libraryUrl;
		$countries = self::$instantGlobalsVariable;
		$vertical = HubService::getVerticalNameForComscore( $wgCityId );

		$code = <<<CODE
<!-- Begin IVW3 Tag -->
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

		if (geo.isProperGeo(instantGlobals['{$countries}'])) {
			iom.c(iamData, 2);
		};
	});
</script>
<!-- End IVW3 Tag -->
CODE;

		switch ($event) {
			case AnalyticsEngine::EVENT_PAGEVIEW:
				return $code;
			default:
				return '<!-- Unsupported event for IVW3 -->';
		}
	}
}
