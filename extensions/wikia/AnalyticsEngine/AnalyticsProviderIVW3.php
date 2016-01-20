<?php

class AnalyticsProviderIVW3 implements iAnalyticsProvider {

	private static $libraryUrl = 'https://script.ioam.de/iam.js';

	static public function onInstantGlobalsGetVariables( array &$vars )
	{
		$vars[] = 'wgSitewideDisableIVW3';

		return true;
	}

	function getSetupHtml( $params = array() ) {
		return null;
	}

	function trackEvent( $event, $eventDetails = array() ) {
		if ( !self::isEnabled() ) {
			return '<!-- IVW3 disabled -->';
		}

		switch ($event) {
			case AnalyticsEngine::EVENT_PAGEVIEW:
				return $this->trackPageView();
			default:
				return '<!-- Unsupported event for IVW3 -->';
		}
	}

	static public function isEnabled() {
		global $wgSitewideDisableIVW3, $wgNoExternals;

		return !$wgSitewideDisableIVW3 && !$wgNoExternals;
	}

	private function trackPageView() {
		global $wgCityId;

		$vertical = HubService::getVerticalNameForComscore( $wgCityId );
		$url = self::$libraryUrl;
		$iamData = json_encode( [
				'st' => 'wikia',
				'cp' => $vertical,
				'sv' => 'ke',
		] );

		$ivwScriptTag = <<<CODE
<script type="text/javascript" src="{$url}"></script>
<script type="text/javascript">window.iom.c({$iamData}, 2);</script>
CODE;
		$ivwScriptTagEscaped = json_encode($ivwScriptTag);

		return <<<CODE
<!-- Begin IVW3 Tag -->
<script type="text/javascript">
	if (window.Wikia && window.Wikia.geo.isProperGeo(['DE', 'AT', 'CH'])) {
		window.ivw3Initialized = true;
		document.write({$ivwScriptTagEscaped});
	}
</script>
<!-- End IVW3 Tag -->
CODE;
	}
}
