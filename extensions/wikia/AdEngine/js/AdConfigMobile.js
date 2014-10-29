/*global define*/
define('ext.wikia.adEngine.adConfigMobile', [
	'wikia.log',
	'wikia.document',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.directGptMobile',
	'ext.wikia.adEngine.provider.remnantGptMobile',
	'ext.wikia.adEngine.provider.null'
], function (log, document, adContext, adProviderDirectGpt, adProviderRemnantGpt, adProviderNull) {
	'use strict';

	var pageTypesWithAdsOnMobile = {
		'all_ads': true,
		'corporate': true
	};

	function getProvider(slot) {
		var slotName = slot[0],
			context = adContext.getContext();

		// If wgShowAds set to false, hide slots
		if (!context.opts.showAds) {
			return adProviderNull;
		}

		// On pages with type other than all_ads (corporate, homepage_logged, maps), hide slots
		// @see https://docs.google.com/a/wikia-inc.com/document/d/1Lxz0PQbERWSFvmXurvJqOjPMGB7eZR86V8tpnhGStb4/edit
		if (!pageTypesWithAdsOnMobile[context.opts.pageType]) {
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

		if (adProviderDirectGpt.canHandleSlot(slotName)) {
			return adProviderDirectGpt;
		}

		return adProviderNull;

	}

	function getProviderList(slot) {
		return [getProvider(slot)];
	}

	return {
		getDecorators: function () { return []; },
		getProviderList: getProviderList
	};
});
