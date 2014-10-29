/*global define,require*/
define('ext.wikia.adEngine.adConfig', [
	// regular dependencies
	'wikia.log',
	'wikia.geo',

	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adDecoratorPageDimensions',
	'ext.wikia.adEngine.evolveSlotConfig',
	'ext.wikia.adEngine.gptSlotConfig',
	require.optional('ext.wikia.adEngine.rubiconRtp'),

	// adProviders
	'ext.wikia.adEngine.provider.directGpt',
	'ext.wikia.adEngine.provider.later',

	// adSlots
	require.optional('ext.wikia.adEngine.slot.topInContentBoxad')
], function (
	// regular dependencies
	log,
	geo,

	adContext,
	adDecoratorPageDimensions,
	evolveSlotConfig,
	gptSlotConfig,
	rtp,

	// adProviders
	adProviderDirectGpt,
	adProviderLater,

	// adSlots
	topInContentBoxad
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adConfig',
		country = geo.getCountryCode(),
		defaultHighValueSlots,
		highValueSlots,
		decorators = [adDecoratorPageDimensions],
		rtpTier;

	defaultHighValueSlots = {
		'CORP_TOP_LEADERBOARD': true,
		'CORP_TOP_RIGHT_BOXAD': true,
		'EXIT_STITIAL_BOXAD_1': true,
		'HOME_TOP_LEADERBOARD': true,
		'HOME_TOP_RIGHT_BOXAD': true,
		'HUB_TOP_LEADERBOARD': true,
		'INVISIBLE_SKIN': true,
		'LEFT_SKYSCRAPER_2': true,
		'MIDDLE_RIGHT_BOXAD': true,
		'MODAL_RECTANGLE': true,
		'MODAL_INTERSTITIAL': true,
		'MODAL_INTERSTITIAL_1': true,
		'MODAL_INTERSTITIAL_2': true,
		'MODAL_INTERSTITIAL_3': true,
		'MODAL_INTERSTITIAL_4': true,
		'TEST_HOME_TOP_RIGHT_BOXAD': true,
		'TEST_TOP_RIGHT_BOXAD': true,
		'TOP_INCONTENT_BOXAD': true,
		'TOP_LEADERBOARD': true,
		'TOP_RIGHT_BOXAD': true,
		'BOTTOM_LEADERBOARD': true,
		'GPT_FLUSH': true
	};

	highValueSlots = defaultHighValueSlots;

	function getProviderList(slot) {
		log(['getProvider', slot], 'info', logGroup);

		var slotname = slot[0],
			context = adContext.getContext();

		if (!adContext.getContext().opts.showAds) {
			return [];
		}

		// Force Liftium
		if (context.forceProviders.liftium) {
			log(['getProvider', slot, 'Later (wgAdDriverForceLiftiumAd)'], 'info', logGroup);
			return [adProviderLater];
		}

		// Force DirectGpt
		if (context.forceProviders.directGpt) {
			log(['getProvider', slot, 'DirectGpt (wgAdDriverForceDirectGptAd)'], 'info', logGroup);
			return [adProviderDirectGpt];
		}

		// All SevenOne Media ads are handled in the Later queue
		// SevenOne Media gets all but WIKIA_BAR_BOXAD_1 and TOP_BUTTON
		// TOP_BUTTON is always handled in Later queue, so we need to exclude
		// only WIKIA_BAR_BOXAD_1.
		// Also we need to add an exception for GPT_FLUSH, so that WIKIA_BAR_BOXAD_1
		// is actually requested.
		if (context.providers.sevenOneMedia &&
				slotname !== 'WIKIA_BAR_BOXAD_1' &&
				slotname !== 'GPT_FLUSH'
				) {
			log(['getProvider', slot, 'Later (SevenOneMedia)'], 'info', logGroup);
			return [adProviderLater];
		}

		// Next Evolve (AU, CA, and NZ traffic)
		if (country === 'AU' || country === 'CA' || country === 'NZ') {
			if (evolveSlotConfig.canHandleSlot(slotname)) {
				log(['getProvider', slot, 'Later (Evolve)'], 'info', logGroup);
				return [adProviderLater];
			}
		}

		if (highValueSlots[slotname]) {
			log(['getProvider', slot, 'DirectGpt->Later'], 'info', logGroup);
			return [adProviderDirectGpt, adProviderLater];
		}

		// Non-high-value slots go to ad provider Later
		log(['getProvider', slot, 'Later (Liftium)'], 'info', logGroup);
		return [adProviderLater];
	}

	if (topInContentBoxad) {
		topInContentBoxad.init();
	}

	if (rtp && rtp.wasCalled()) {
		rtp.trackState();
		rtpTier = rtp.getTier();
		if (rtpTier) {
			// TODO: fix repetition while working on multi slot support
			gptSlotConfig.extendSlotParams('gpt', 'HOME_TOP_RIGHT_BOXAD', { 'rp_tier': rtpTier });
			gptSlotConfig.extendSlotParams('gpt', 'TOP_RIGHT_BOXAD', { 'rp_tier': rtpTier });
			gptSlotConfig.extendSlotParams('gpt', 'TOP_INCONTENT_BOXAD', { 'rp_tier': rtpTier });
			gptSlotConfig.extendSlotParams('gpt', 'CORP_TOP_RIGHT_BOXAD', { 'rp_tier': rtpTier });
		}
	}

	return {
		getDecorators: function () { return decorators; },
		getProviderList: getProviderList
	};
});
