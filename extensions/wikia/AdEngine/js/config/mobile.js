/*global define,require*/
define('ext.wikia.adEngine.config.mobile', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.directGptMobile',
	'ext.wikia.adEngine.provider.remnantGptMobile',
	require.optional('ext.wikia.adEngine.provider.taboola'),
	require.optional('wikia.instantGlobals')
], function (adContext, directGptMobile, remnantGptMobile, taboola, instantGlobals) {
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

		if (!context.opts.enableInvisibleHighImpactSlot && slotName === 'INVISIBLE_HIGH_IMPACT') {
			return [];
		}

		if (context.providers.taboola && taboola && taboola.canHandleSlot(slotName)) {
			return [taboola];
		}

		if (instantGlobals && instantGlobals.wgSitewideDisableGpt) {
			return [];
		}

		return [directGptMobile, remnantGptMobile];
	}

	return {
		getDecorators: function () { return []; },
		getProviderList: getProviderList
	};
});

// Can be removed after ADEN-1921 is done
define('ext.wikia.adEngine.adConfigMobile', [
	'ext.wikia.adEngine.config.mobile'
], function (configMobile) {
	'use strict';
	return configMobile;
});
