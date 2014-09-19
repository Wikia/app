<?php

class AnalyticsProviderRubiconRTP implements iAnalyticsProvider {

	const OZ_SITE = '7450/11979';
	const OZ_ZONE = '145168';


	public static function isEnabled() {
		global $wgSitewideDisableRubiconRTP, $wgEnableAdEngineExt, $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return !$wgSitewideDisableRubiconRTP
			&& $wgEnableAdEngineExt
			&& $wgShowAds
			&& AdEngine2Service::areAdsShowableOnPage()
			&& !$wgAdDriverUseSevenOneMedia;
	}

	public function getSetupHtml($params = array()) {

		global $wgAdDriverRubiconCachedOnly;

		static $called = false;
		$code = '';

		$ozSite = json_encode(self::OZ_SITE);
		$ozZone = json_encode(self::OZ_ZONE);
		$ozSlotSize = json_encode('300x250');
		$ozCachedOnly = json_encode((bool)$wgAdDriverRubiconCachedOnly);
		$scriptUrl = json_encode('//tap-cdn.rubiconproject.com/partner/scripts/rubicon/dorothy.js?pc=' . self::OZ_SITE);


		if (!$called && self::isEnabled()) {
			$code = <<< SCRIPT
<script>
	require(['wikia.window', 'wikia.geo', 'wikia.instantGlobals'], function (window, geo, globals) {
		if (!globals.wgSitewideDisableRubiconRTP && geo.getCountryCode() == "US" ) {
			var s, i, config = {
				rp_performance: {
					Start: Math.round(new Date().getTime() - window.wgNow.getTime()),
					End: null
				},
				oz_async: true,
				oz_cached_only: {$ozCachedOnly},
				oz_api: "valuation",
				oz_ad_server: "dart",
				oz_site: {$ozSite},
				oz_zone: {$ozZone},
				oz_ad_slot_size: {$ozSlotSize},
				oz_callback: function(response) {
					var i, tracker = window.Wikia && window.Wikia.Tracker;

					rp_performance.End = Math.round(new Date().getTime() - window.wgNow.getTime());
					for (i in window.rp_performance) {
						tracker.track({
							ga_category: 'ad/performance/rubicon' + i + '/wgNow',
							ga_action: 'oz_cached_only=' + !!window.wgAdDriverRubiconCachedOnly,
							ga_value: rp_performance[i],
							trackingMethod: 'ad'
						});
					}

					window.wgAfterContentAndJS.push(function() {
						if (window.AdEngine_trackRubicon) {
							AdEngine_trackRubicon('End', response);
						}
					});
				}
			};

			for(i in config) {
				window[i] = config[i];
			}

			s = document.createElement('script');
			s.src = {$scriptUrl};
			s.async = true;
			document.body.appendChild(s);
		}
	});
</script>
SCRIPT;
		}

		return $code;
	}

	public function trackEvent($event, $eventDetails = array()) {
		return '';
	}
}
