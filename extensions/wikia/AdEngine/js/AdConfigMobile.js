/*global define*/
define('ext.wikia.adEngine.adConfigMobile', [
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'ext.wikia.adEngine.provider.directGptMobile',
	'ext.wikia.adEngine.provider.remnantGptMobile',
	'ext.wikia.adEngine.provider.null',
	'ext.wikia.adEngine.provider.ebay'
], function (log, window, document, adProviderDirectGpt, adProviderRemnantGpt, adProviderNull, adProviderEbay) {
	'use strict';

	var pageTypesWithAdsOnMobile = {
		'all_ads': true,
		'corporate': true
	};

	function getProvider(slot) {
		var slotName = slot[0];

		// If wgShowAds set to false, hide slots
		if (!window.wgShowAds) {
			return adProviderNull;
		}

		// On pages with type other than all_ads (corporate, homepage_logged, maps), hide slots
		// @see https://docs.google.com/a/wikia-inc.com/document/d/1Lxz0PQbERWSFvmXurvJqOjPMGB7eZR86V8tpnhGStb4/edit
		if (!pageTypesWithAdsOnMobile[window.adEnginePageType]) {
			return adProviderNull;
		}

		if (slot[2] === 'Null') {
			return adProviderNull;
		}

		if (slot[2] === 'RemnantGptMobile') {
			if (adProviderRemnantGpt.canHandleSlot(slotName)) {
				return adProviderRemnantGpt;
			}
			return adProviderNull;
		}

		if (window.wgAdDriverUseEbay && adProviderEbay.canHandleSlot(slotName)) {
			document.getElementById(slotName).className += ' show';
			return adProviderEbay;
		}

		if (adProviderDirectGpt.canHandleSlot(slotName)) {
			return adProviderDirectGpt;
		}

		return adProviderNull;

	}

	return {
		getDecorators: function () { return []; },
		getProvider: getProvider
	};
});
