<?php

class AnalyticsProviderNielsen implements iAnalyticsProvider {

	private static $apid = 'XXXXXXXXXX-XXXX-XXXX-XXXXXXXXXX';
	private static $clientId = 'Wikia';
	private static $libraryUrl = 'http://secure-dcr-cert.imrworldwide.com/novms/js/2/ggcmb500.js';

	function getSetupHtml( $params=array() ) {
		return null;
	}

	function trackEvent( $event, $eventDetails=array() ) {
		global $wgCityId;

		$url = self::$libraryUrl;
		$apid = self::$apid;
		$clientId = self::$clientId;
		$wg = F::app()->wg;
		$section = HubService::getVerticalNameForComscore( $wgCityId );

		if (!$this->isEnabled()) {
			return '<!-- Nielsen is disabled -->';
		}

		switch ($event) {
			case AnalyticsEngine::EVENT_PAGEVIEW:
				return <<<EOT
<!-- Begin Nielsen Tag -->
<script type="text/javascript" src="{$url}"></script>
<script type="text/javascript">
	var _nolggGlobalParams = {
			sfcode: 'dcr-cert',
			apid: '{$apid}',
			apn : 'test-static'
		},
		gg1 = NOLCMB.getInstance(_nolggGlobalParams),
		staticmeta = {
			clientid: '{$clientId}',
			subbrand: '{$wg->DBname}',
			type: 'static',
			assetid: '{$section}',
			section: '{$section}',
			segA: '',
			segB: '',
			segC: ''
		};

	gg1.ggInitialize(_nolggGlobalParams);
	gg1.ggPM('staticstart', staticmeta);
</script>
<!-- End Nielsen Tag -->
EOT;
			default:
				return '<!-- Unsupported event for Nielsen -->';
		}
	}

	private function isEnabled() {
		global $wgEnableNielsen, $wgNoExternals;

		return $wgEnableNielsen && !$wgNoExternals;
	}
}
