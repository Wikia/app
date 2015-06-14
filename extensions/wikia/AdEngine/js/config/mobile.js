/*global define,require*/
define('ext.wikia.adEngine.config.mobile', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.directGptMobile',
	'ext.wikia.adEngine.provider.openX',
	'ext.wikia.adEngine.provider.paidAssetDrop',
	'ext.wikia.adEngine.provider.remnantGptMobile',
	require.optional('ext.wikia.adEngine.provider.taboola'),
	require.optional('wikia.instantGlobals')
], function (adContext, directGptMobile, openX, paidAssetDrop, remnantGptMobile, taboola, instantGlobals) {
	'use strict';

	var pageTypesWithAdsOnMobile = {
			'all_ads': true,
			'corporate': true
		};

	function getProviderList(slotName) {
		var context = adContext.getContext(),
			providerList = [];

		// If wgShowAds set to false, hide slots
		if (!context.opts.showAds) {
			return [];
		}

		// On pages with type other than all_ads (corporate, homepage_logged, maps), hide slots
		// @see https://docs.google.com/a/wikia-inc.com/document/d/1Lxz0PQbERWSFvmXurvJqOjPMGB7eZR86V8tpnhGStb4/edit
		if (!pageTypesWithAdsOnMobile[context.opts.pageType]) {
			return [];
		}

		if (context.forceProviders.openX) {
			return [openX];
		}

		if (!context.slots.invisibleHighImpact && slotName === 'INVISIBLE_HIGH_IMPACT') {
			return [];
		}

		if (context.providers.taboola && taboola && taboola.canHandleSlot(slotName)) {
			return [taboola];
		}

		if (paidAssetDrop.canHandleSlot(slotName)) {
			return [paidAssetDrop];
		}

		if (instantGlobals && instantGlobals.wgSitewideDisableGpt) {
			return [];
		}

		providerList.push(directGptMobile);
		providerList.push(remnantGptMobile);

		if (context.providers.openX && openX.canHandleSlot(slotName)) {
			providerList.push(openX);
		}

		return providerList;
	}

	return {
		getDecorators: function () { return []; },
		getProviderList: getProviderList
	};
});
