<?php

class AnalyticsProviderBlueKai implements iAnalyticsProvider
{

	const SITE_ID = '11850';

	// Keeping the response size (assets minification) and the number of external requests low (aggregation)
	static public function onWikiaMobileAssetsPackages( Array &$jsStaticPackages, Array &$jsExtensionPackages, Array &$scssPackages ) {
		$jsStaticPackages[] = 'analytics_bluekai_js';
		return true;
	}

	function getSetupHtml( $params = array() )
	{
		return null;
	}

	function trackEvent( $event, $eventDetails = array() )
	{

		$siteId = self::SITE_ID;

		$allowedParams = json_encode([
				'esrb' => true,
				'gnre' => true,
				'pub' => true,
				'dev' => true,
				'pform' => true,
				'wpage' => true,
				'lang' => true,
				'onSiteSearch' => true,
		]);

		switch ( $event ) {
			case AnalyticsEngine::EVENT_PAGEVIEW:
				$script = <<<SCRIPT
<!-- Begin BlueKai Tag -->
<iframe name="__bkframe" height="0" width="0" frameborder="0" "src="javascript:void(0)" class="hidden"></iframe>
<script type="text/javascript">
window.bk_async = function() {
require(['ext.wikia.adEngine.adLogicPageParams'], function(adLogicPageParams){
	var i,
		paramName,
		allowedParams = {$allowedParams},
		pageParams = adLogicPageParams.getPageLevelParams();

	for (param in pageParams){
		if (pageParams.hasOwnProperty(param) && allowedParams[param]) {
			if (typeof pageParams[param] === "string") {
				pageParams[param] = [pageParams[param]];
			}
			for(i=0;i<pageParams[param].length;i++) {
				bk_addPageCtx(param, pageParams[param][i]);
			}

		}
	}
	BKTAG.doTag({$siteId}, 1);
});
};
(function() {
var scripts = document.getElementsByTagName('script')[0];
var s = document.createElement('script');
s.async = true;
s.src = "http://tags.bkrtx.com/js/bk-coretag.js";
scripts.parentNode.insertBefore(s, scripts);
}());
</script>
<!-- End BlueKai Tag -->
SCRIPT;

				return $script;
			default:
				return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

}
