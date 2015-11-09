/*global define,require*/
define('ext.wikia.adEngine.config.mobile', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.directGptMobile',
	'ext.wikia.adEngine.provider.openX',
	'ext.wikia.adEngine.provider.paidAssetDrop',
	'ext.wikia.adEngine.provider.remnantGptMobile'
], function (adContext, directGptMobile, openX, paidAssetDrop, remnantGptMobile) {
	'use strict';

	var pageTypesWithAdsOnMobile = {
		'all_ads': true,
		'corporate': true
	};

	function getProviderList(slotName) {
		var context = adContext.getContext(),
			providerList = [],
			adProviderTaboola,
			instantGlobals;

		// If wgShowAds set to false, hide slots
		if (!context.opts.showAds) {
			return [];
		}

		// On pages with type other than all_ads (corporate, homepage_logged, maps), hide slots
		// @see https://docs.google.com/a/wikia-inc.com/document/d/1Lxz0PQbERWSFvmXurvJqOjPMGB7eZR86V8tpnhGStb4/edit
		if (!pageTypesWithAdsOnMobile[context.opts.pageType]) {
			return [];
		}

		if (context.forcedProvider === 'openx') {
			return [openX];
		}

		if (!context.slots.invisibleHighImpact && slotName === 'INVISIBLE_HIGH_IMPACT') {
			return [];
		}

		// Taboola
		if (context.providers.taboola) {
			try {
				adProviderTaboola = require('ext.wikia.adEngine.provider.taboola');

				if (adProviderTaboola.canHandleSlot(slotName)) {
					return [adProviderTaboola];
				}
			} catch (exception) {
			}
		}

		if (paidAssetDrop.canHandleSlot(slotName)) {
			return [paidAssetDrop];
		}

		try {
			instantGlobals = require('wikia.instantGlobals');

			if (!instantGlobals.wgSitewideDisableGpt) {
				providerList.push(directGptMobile);
				providerList.push(remnantGptMobile);
			}
		} catch (exception) {
		}

		if (context.providers.openX && openX.canHandleSlot(slotName)) {
			providerList.push(openX);
		}

		return providerList;
	}

	return {
		getDecorators: function () {
			return [];
		},
		getProviderList: getProviderList
	};
});
