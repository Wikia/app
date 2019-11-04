// Initialize ads module
require(['ext.wikia.adEngine3.ads'], function (ads) {
	ads.run();
});

// AdEngine3 JS API that can be used outside extensions/Wikia/AdEngine3 directory
define('ext.wikia.adEngine3.api', [
	'ext.wikia.adEngine3.ads'
], function (ads) {
	function shouldShowAds() {
		return ads.contextConfigured.then(function(context) {
			return context.get('state.showAds')
		});
	}

	function isNetzathletenEnabled() {
		return ads.contextConfigured.then(function(context) {
			return context.get('services.netzathleten.enabled')
		});
	}

	return {
		communicator: ads.communicator,
		isAutoPlayDisabled: ads.isAutoPlayDisabled,
		isNetzathletenEnabled: isNetzathletenEnabled,
		shouldShowAds: shouldShowAds,
		jwplayerAdsFactory: ads.jwplayerAdsFactory,
		waitForAdStackResolve: ads.waitForAdStackResolve
	}
});
