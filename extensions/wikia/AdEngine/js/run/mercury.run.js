/*global require*/
require([
	'ext.wikia.adEngine.lookup.amazonMatch',
	'ext.wikia.adEngine.lookup.openXBidder',
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.adEngine.mobile.mercuryListener',
	'ext.wikia.adEngine.slot.scrollHandler',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.window'
], function (
	amazon,
	oxBidder,
	customAdsLoader,
	messageListener,
	mercuryListener,
	scrollHandler,
	geo,
	instantGlobals,
	win
) {
	'use strict';
	var skin = 'mercury';

	// @TODO refactor this method after ADEN-2430 by using new module?
	function isProperCountry(countryList) {
		return !!(countryList && countryList.indexOf && countryList.indexOf(geo.getCountryCode()) > -1);
	}

	messageListener.init();
	scrollHandler.init(skin);

	// Custom ads (skins, footer, etc)
	win.loadCustomAd = customAdsLoader.loadCustomAd;

	if (isProperCountry(instantGlobals.wgAmazonMatchCountriesMobile)) {
		amazon.call();
	}

	mercuryListener.onLoad(function () {
		if (isProperCountry(instantGlobals.wgAdDriverOpenXBidderCountriesMobile)) {
			oxBidder.call(skin);
		}
	});
});
