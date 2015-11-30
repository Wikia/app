/*global define,require*/
define('ext.wikia.adEngine.config.mobile', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.directGptMobile',
	'ext.wikia.adEngine.provider.evolve2',
	'ext.wikia.adEngine.provider.openX',
	'ext.wikia.adEngine.provider.paidAssetDrop',
	'ext.wikia.adEngine.provider.remnantGptMobile',
	require.optional('wikia.instantGlobals')
], function (
	adContext,
	directGptMobile,
	evolve2,
	openX,
	paidAssetDrop,
	remnantGptMobile,
	instantGlobals
) {
	'use strict';

	var pageTypesWithAdsOnMobile = {
			'all_ads': true,
			'corporate': true
		},
		dartEnabled = !instantGlobals || !instantGlobals.wgSitewideDisableGpt;

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

		switch (context.forcedProvider) {
			case 'evolve2':
				return [evolve2];
			case 'openx':
				return [openX];
		}

		if (!context.slots.invisibleHighImpact && slotName === 'INVISIBLE_HIGH_IMPACT') {
			return [];
		}

		if (paidAssetDrop.canHandleSlot(slotName)) {
			return [paidAssetDrop];
		}

		if (context.providers.evolve2 && evolve2.canHandleSlot(slotName)) {
			providerList.push(evolve2);
		} else if (dartEnabled) {
			providerList.push(directGptMobile);
		}

		if (dartEnabled) {
			providerList.push(remnantGptMobile);
		}

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
