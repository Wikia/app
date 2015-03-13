/*global define,require*/
define('ext.wikia.adEngine.adConfigMobile', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.directGptMobile',
	'ext.wikia.adEngine.provider.remnantGptMobile',
	'ext.wikia.adEngine.provider.turtle',
	require.optional('ext.wikia.adEngine.provider.taboola'),
	require.optional('wikia.instantGlobals')
], function (adContext, directGptMobile, remnantGptMobile, turtle, taboola, instantGlobals) {
	'use strict';

	var pageTypesWithAdsOnMobile = {
			'all_ads': true,
			'corporate': true
		};

	function getProviderList(slotName) {
		var context = adContext.getContext();

		// If wgShowAds set to false, hide slots
		if (!context.opts.showAds) {
			return [];
		}

		// On pages with type other than all_ads (corporate, homepage_logged, maps), hide slots
		// @see https://docs.google.com/a/wikia-inc.com/document/d/1Lxz0PQbERWSFvmXurvJqOjPMGB7eZR86V8tpnhGStb4/edit
		if (!pageTypesWithAdsOnMobile[context.opts.pageType]) {
			return [];
		}

		if (context.providers.taboola && taboola && taboola.canHandleSlot(slotName)) {
			return [taboola];
		}

		if (instantGlobals && instantGlobals.wgSitewideDisableGpt) {
			return [];
		}

		if (context.providers.turtle) {
			return [turtle, remnantGptMobile];
		}

		return [directGptMobile, remnantGptMobile];
	}

	return {
		getDecorators: function () { return []; },
		getProviderList: getProviderList
	};
});
