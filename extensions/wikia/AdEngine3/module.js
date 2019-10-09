// Initialize ads module
require(['ext.wikia.adEngine3.ads'], function (ads) {
	ads.run();

	registerEditorSavedEvents(ads);
});

function registerEditorSavedEvents(ads) {
	var eventId = 'M-FnMTsI';

	window.wgAfterContentAndJS.push(() => {
		// VE editor save complete
		window.ve.trackSubscribe('mwtiming.performance.user.saveComplete', () => {
			ads.krux.fireEvent(eventId);
		});

		// MW/CK editor saving in progress
		window.mw.hook('mwEditorSaved').add(() => {
			ads.krux.fireEvent(eventId);
		});
	});
}

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
		getHmdConfig: ads.hmdLoader.getConfig,
		injectIncontentBoxad: ads.slots.injectIncontentBoxad,
		isAutoPlayDisabled: ads.isAutoPlayDisabled,
		isNetzathletenEnabled: isNetzathletenEnabled,
		shouldShowAds: shouldShowAds,
		jwplayerAdsFactory: ads.jwplayerAdsFactory,
		waitForAdStackResolve: ads.waitForAdStackResolve
	}
});
