<?php

class AnalyticsProviderClarityRay implements iAnalyticsProvider
{
	static public function onSkinAfterBottomScripts($skin, &$bottomScriptText) {
		$bottomScriptText = $bottomScriptText . AnalyticsEngine::track('ClarityRay', AnalyticsEngine::EVENT_PAGEVIEW);

		return true;
	}

	function getSetupHtml( $params = array() )
	{
		return null;
	}

	function trackEvent( $event, $eventDetails = array() )
	{

		global $wgCityId;

		$code = json_encode(HubService::getCategoryInfoForCity($wgCityId)->cat_name);

		switch ( $event ) {
			case AnalyticsEngine::EVENT_PAGEVIEW:
				$script = <<<SCRIPT
<script type='text/javascript'>
var agllGroup = {$code};
!function(){
var a=document.createElement("script");a.type="text/javascript";a.async=!0;var b=["http://a98dc034c7781a941eba-bac02262202668bbe918ea9fb5289cd2.r58.cf2.rackcdn.com","https://52e473ee9859b886964f-bac02262202668bbe918ea9fb5289cd2.ssl.cf2.rackcdn.com"];a.src=("https:"==document.location.protocol?b[1]:b[0])+"/c59hk50tip94.js";var c=document.getElementsByTagName("script")[0];c.parentNode.insertBefore(a,c)
}();</script>
SCRIPT;

				return $script;
			default:
				return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

}
