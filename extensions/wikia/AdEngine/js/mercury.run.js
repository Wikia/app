/*global require*/
require([
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.messageListener'
], function (
	customAdsLoader,
	messageListener
) {
	'use strict';
	messageListener.init();

	// Custom ads (skins, footer, etc)
	window.loadCustomAd = customAdsLoader.loadCustomAd;
});
