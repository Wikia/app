// Initialize ads module
require(['ext.wikia.adEngine3.ads'], function (ads) {
	ads.run();
});

// AdEngine3 JS API that can be used outside extensions/Wikia/AdEngine3 directory
define('ext.wikia.adEngine3.api', [
	'ext.wikia.adEngine3.ads'
], function (ads) {
	function shouldShowAds() {
		return ads.context.get('state.showAds');
	}

	function isNetzathletenEnabled() {
		return ads.context.get('services.netzathleten.enabled');
	}

	return {
		getHmdConfig: ads.hmdLoader.getConfig,
		injectIncontentBoxad: ads.slots.injectIncontentBoxad,
		isAutoPlayDisabled: ads.isAutoPlayDisabled,
		isNetzathletenEnabled: isNetzathletenEnabled,
		shouldShowAds: shouldShowAds,
		jwplayerAdsFactory: ads.jwplayerAdsFactory,
		waitForAdStackResolve: ads.waitForAdStackResolve
	}
});
