/*global define*/
define('ext.wikia.adEngine.adConfig', [
	// regular dependencies
	'wikia.log',
	'wikia.geo',
	'wikia.instantGlobals',

	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adDecoratorPageDimensions',
	'ext.wikia.adEngine.evolveSlotConfig',

	// adProviders
	'ext.wikia.adEngine.provider.directGpt',
	'ext.wikia.adEngine.provider.later',
	'ext.wikia.adEngine.provider.turtle',
	'ext.wikia.adEngine.provider.szymon'
], function (
	// regular dependencies
	log,
	geo,
	instantGlobals,

	adContext,
	adDecoratorPageDimensions,
	evolveSlotConfig,

	// adProviders
	adProviderDirectGpt,
	adProviderLater,
	adProviderTurtle,
	adProviderSzymon
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adConfig',
		country = geo.getCountryCode(),
		decorators = [adDecoratorPageDimensions],
		highValueSlots = {
			'CORP_TOP_LEADERBOARD': true,
			'CORP_TOP_RIGHT_BOXAD': true,
			'EXIT_STITIAL_BOXAD_1': true,
			'HOME_TOP_LEADERBOARD': true,
			'HOME_TOP_RIGHT_BOXAD': true,
			'HUB_TOP_LEADERBOARD': true,
			'INCONTENT_1A': true,
			'INCONTENT_1B': true,
			'INCONTENT_1C': true,
			'INCONTENT_2A': true,
			'INCONTENT_2B': true,
			'INCONTENT_2C': true,
			'INCONTENT_3A': true,
			'INCONTENT_3B': true,
			'INCONTENT_3C': true,
			'INCONTENT_BOXAD_1': true,
			'INCONTENT_LEADERBOARD_1': true,
			'INCONTENT_LEADERBOARD_2': true,
			'INCONTENT_LEADERBOARD_3': true,
			'INVISIBLE_SKIN': true,
			'LEFT_SKYSCRAPER_2': true,
			'MODAL_RECTANGLE': true,
			'MODAL_INTERSTITIAL': true,
			'MODAL_INTERSTITIAL_1': true,
			'MODAL_INTERSTITIAL_2': true,
			'MODAL_INTERSTITIAL_3': true,
			'MODAL_INTERSTITIAL_4': true,
			'MODAL_INTERSTITIAL_5': true,
			'TEST_HOME_TOP_RIGHT_BOXAD': true,
			'TEST_TOP_RIGHT_BOXAD': true,
			'TOP_LEADERBOARD': true,
			'TOP_RIGHT_BOXAD': true,
			'GPT_FLUSH': true
		};

	function getProviderList(slotname) {
		log(['getProvider', slotname], 'info', logGroup);

		var context = adContext.getContext();

		if (!adContext.getContext().opts.showAds) {
			return [];
		}

        // Force szymon
        if (context.forceProviders.szymon) {
            log(['getProvider', slotname, 'Later (wgAdDriverForceSzymonAd)'], 'info', logGroup);
            return [adProviderSzymon];
        }

		// Force Liftium
		if (context.forceProviders.liftium) {
			log(['getProvider', slotname, 'Later (wgAdDriverForceLiftiumAd)'], 'info', logGroup);
			return [adProviderLater];
		}

		// Force DirectGpt
		if (context.forceProviders.directGpt) {
			log(['getProvider', slotname, 'DirectGpt (wgAdDriverForceDirectGptAd)'], 'info', logGroup);
			return [adProviderDirectGpt];
		}

		// All SevenOne Media ads are handled in the Later queue
		// beside GPT_FLUSH which needs to be handled by GPT
		if (context.providers.sevenOneMedia && slotname !== 'GPT_FLUSH') {
			log(['getProvider', slotname, 'Later (SevenOneMedia)'], 'info', logGroup);
			return [adProviderLater];
		}

		// Next Evolve (AU, CA, and NZ traffic)
		if (country === 'AU' || country === 'CA' || country === 'NZ') {
			if (evolveSlotConfig.canHandleSlot(slotname)) {
				log(['getProvider', slotname, 'Later (Evolve)'], 'info', logGroup);
				return [adProviderLater];
			}
		}

		if (highValueSlots[slotname]) {
			if (instantGlobals.wgSitewideDisableGpt) {
				log(['getProvider', slotname, 'wgSitewideDisableGpt ON skipping DirectGPT'], 'warning', logGroup);
				return [adProviderLater];
			}

			if (context.providers.turtle) {
				log(['getProvider', slotname, 'Turtle->Later'], 'info', logGroup);
				return [adProviderTurtle, adProviderLater];
			}

			log(['getProvider', slotname, 'DirectGpt->Later'], 'info', logGroup);
			return [adProviderDirectGpt, adProviderLater];
		}

		// Non-high-value slots go to ad provider Later
		log(['getProvider', slotname, 'Later (Liftium)'], 'info', logGroup);
		return [adProviderLater];
	}

	return {
		getDecorators: function () { return decorators; },
		getProviderList: getProviderList
	};
});
