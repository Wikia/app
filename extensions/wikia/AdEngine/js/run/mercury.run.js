/*global require*/
(function () {
	'use strict';
	var amazon = require('ext.wikia.adEngine.lookup.amazonMatch'),
		oxBidder = require('ext.wikia.adEngine.lookup.openXBidder'),
		customAdsLoader = require('ext.wikia.adEngine.customAdsLoader'),
		messageListener = require('ext.wikia.adEngine.messageListener'),
		mercuryListener	= require('ext.wikia.adEngine.mobile.mercuryListener'),
		scrollHandler = require('ext.wikia.adEngine.slot.scrollHandler'),
		geo = require('wikia.geo'),
		instantGlobals = require('wikia.instantGlobals'),
		win = require('wikia.window'),
		skin = 'mercury';

	messageListener.init();
	scrollHandler.init(skin);

	// Custom ads (skins, footer, etc)
	win.loadCustomAd = customAdsLoader.loadCustomAd;

	if (geo.isProperGeo(instantGlobals.wgAmazonMatchCountriesMobile)) {
		amazon.call();
	}

	mercuryListener.onLoad(function () {
		if (geo.isProperGeo(instantGlobals.wgAdDriverOpenXBidderCountriesMobile)) {
			oxBidder.call(skin);
		}
	});
})();
