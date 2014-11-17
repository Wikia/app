/*global define,require*/
define('ext.wikia.adEngine.adConfigMobile', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.directGptMobile',
	'ext.wikia.adEngine.provider.remnantGptMobile',
	'ext.wikia.adEngine.provider.taboola',
	require.optional('wikia.abTest')
], function (adContext, adProviderDirectGptMobile, adProviderRemnantGptMobile, adProviderTaboola, abTest) {
	'use strict';

	var context = adContext.getContext(),
		targeting = context.targeting,
		pageTypesWithAdsOnMobile = {
			'all_ads': true,
			'corporate': true
		},
		taboolaEnabledWikis = {
			darksouls: true,
			gameofthrones: true,
			harrypotter: true,
			helloproject: true,
			ladygaga: true,
			onedirection: true
		},
		taboolaEnabled = (targeting.pageType === 'article' || targeting.pageType === 'home') &&
			taboolaEnabledWikis[targeting.wikiDbName] &&
			context.providers.taboola &&
			abTest && abTest.inGroup('NATIVE_ADS_TABOOLA', 'YES');

	function getProviderList(slotName) {

		// If wgShowAds set to false, hide slots
		if (!context.opts.showAds) {
			return [];
		}

		// On pages with type other than all_ads (corporate, homepage_logged, maps), hide slots
		// @see https://docs.google.com/a/wikia-inc.com/document/d/1Lxz0PQbERWSFvmXurvJqOjPMGB7eZR86V8tpnhGStb4/edit
		if (!pageTypesWithAdsOnMobile[context.opts.pageType]) {
			return [];
		}

		if (taboolaEnabled && adProviderTaboola.canHandleSlot(slotName) ) {
			return [adProviderTaboola];
		}

		if (context.providers.remnantGptMobile) {
			return [adProviderDirectGptMobile, adProviderRemnantGptMobile];
		}

		return [adProviderDirectGptMobile];
	}

	return {
		getDecorators: function () { return []; },
		getProviderList: getProviderList
	};
});
