<?php

class AnalyticsProviderPageFair implements iAnalyticsProvider
{
	static public function onSkinAfterBottomScripts($skin, &$bottomScriptText) {
		$bottomScriptText = $bottomScriptText . AnalyticsEngine::track('PageFair', AnalyticsEngine::EVENT_PAGEVIEW);

		return true;
	}

	function getSetupHtml( $params = array() )
	{
		return null;
	}

	function trackEvent( $event, $eventDetails = array() )
	{
		global $wgEnableAdEngineExt, $wgAnalyticsProviderPageFair, $wgShowAds;

		if (!$wgEnableAdEngineExt || !$wgAnalyticsProviderPageFair || !$wgShowAds || !AdEngine2Service::areAdsShowableOnPage()) {
			return '';
		}

		switch ( $event ) {
			case AnalyticsEngine::EVENT_PAGEVIEW:

				$script = <<< SCRIPT
<script type="text/javascript">
$(function() {
		function async_load(script_url){
			var protocol = ('https:' == document.location.protocol ? 'https://' : 'http://');
			var s = document.createElement('script'); s.src = protocol + script_url;
			var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
		}
		bm_website_code = '{$wgAnalyticsProviderPageFair}';
		async_load('asset.pagefair.com/measure.min.js')
		async_load('asset.pagefair.net/ads.min.js')
});
</script>
SCRIPT;


				return $script;
			default:
				return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

}
