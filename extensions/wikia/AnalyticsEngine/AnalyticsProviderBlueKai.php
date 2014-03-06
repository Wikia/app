<?php

class AnalyticsProviderBlueKai implements iAnalyticsProvider
{

	const SITE_ID = '11580';

	function getSetupHtml( $params = array() )
	{
		return null;
	}

	function trackEvent( $event, $eventDetails = array() )
	{

		$siteId = self::SITE_ID;

		switch ( $event ) {
			case AnalyticsEngine::EVENT_PAGEVIEW:
				$script = <<<SCRIPT
<!-- Begin BlueKai Tag -->
<iframe name="__bkframe" height="0" width="0" frameborder="0" "src="javascript:void(0)"></iframe>
<script type="text/javascript">
window.bk_async = function() {
BKTAG.doTag({$siteId}, 1); };
(function() {
var scripts = document.getElementsByTagName('script')[0];
var s = document.createElement('script');
s.async = true;
s.src = "http://tags.bkrtx.com/js/bk-coretag.js";
scripts.parentNode.insertBefore(s, scripts);
}());
</script>
<!-- End BlueKai Tag -->';
SCRIPT;

				return $script;
			default:
				return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

}
