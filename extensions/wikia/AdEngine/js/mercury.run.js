/*global require*/
require([
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.adEngine.customAdsLoader'
], function (
	messageListener,
	customAdsLoader
) {
	'use strict';
	messageListener.init();

	// Custom ads (skins, footer, etc)
	window.loadCustomAd = customAdsLoader.loadCustomAd;
});
