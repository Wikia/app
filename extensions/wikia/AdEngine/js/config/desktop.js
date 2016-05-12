/*global define,require*/
define('ext.wikia.adEngine.config.desktop', [
	// regular dependencies
	'wikia.log',
	'wikia.window',
	'wikia.instantGlobals',
	'wikia.geo',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adDecoratorPageDimensions',

	// adProviders
	'ext.wikia.adEngine.provider.directGpt',
	'ext.wikia.adEngine.provider.evolve2',
	'ext.wikia.adEngine.provider.hitMedia',
	'ext.wikia.adEngine.provider.liftium',
	'ext.wikia.adEngine.provider.monetizationService',
	'ext.wikia.adEngine.provider.remnantGpt',
	'ext.wikia.adEngine.provider.rubiconFastlane',
	'ext.wikia.adEngine.provider.turtle',
	require.optional('ext.wikia.adEngine.provider.taboola')
], function (
	// regular dependencies
	log,
	window,
	instantGlobals,
	geo,
	adContext,
	adDecoratorPageDimensions,

	// AdProviders
	adProviderDirectGpt,
	adProviderEvolve2,
	adProviderHitMedia,
	adProviderLiftium,
	adProviderMonetizationService,
	adProviderRemnantGpt,
	adProviderRubiconFastlane,
	adProviderTurtle,
	adProviderTaboola
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adConfigLate',
		context = adContext.getContext(),
		gptEnabled = !instantGlobals.wgSitewideDisableGpt,
		forcedProviders = {
			evolve2:  [adProviderEvolve2],
			hitmedia: [adProviderHitMedia],
			liftium:  [adProviderLiftium],
			rpfl:     [adProviderRubiconFastlane],
			turtle:   [adProviderTurtle]
		};

	function getDecorators() {
		return [adDecoratorPageDimensions];
	}

	function getProviderList(slotName) {
		var providerList = [];

		log('getProvider', 5, logGroup);
		log(slotName, 5, logGroup);

		// If wgShowAds set to false, hide slots
		if (!context.opts.showAds) {
			return [];
		}

		// Force provider
		if (context.forcedProvider && !!forcedProviders[context.forcedProvider]) {
			log(['getProvider', slotName, context.forcedProvider + ' (wgAdDriverForcedProvider)'], 'info', logGroup);
			return forcedProviders[context.forcedProvider];
		}

		// Taboola
		if (context.providers.taboola && adProviderTaboola && adProviderTaboola.canHandleSlot(slotName)) {
			return [adProviderTaboola];
		}

		// MonetizationService
		if (context.providers.monetizationService && adProviderMonetizationService.canHandleSlot(slotName)) {
			if (instantGlobals.wgSitewideDisableMonetizationService) {
				log('MonetizationService disabled by DR. No ads', 'warn', logGroup);
				return [];
			}
			return [adProviderMonetizationService];
		}

		// First provider: Turtle, Evolve, HitMedia or Direct GPT?
		if (context.providers.turtle && adProviderTurtle.canHandleSlot(slotName)) {
			providerList.push(adProviderTurtle);
		} else if (context.providers.evolve2 && adProviderEvolve2.canHandleSlot(slotName)) {
			providerList.push(adProviderEvolve2);
		} else if (context.providers.hitMedia && adProviderHitMedia.canHandleSlot(slotName)) {
			providerList.push(adProviderHitMedia);
		} else if (gptEnabled) {
			providerList.push(adProviderDirectGpt);
		}

		// Second provider: Remnant GPT
		if (gptEnabled) {
			providerList.push(adProviderRemnantGpt);
		}

		// Last resort provider: RubiconFastlane or Liftium
		if (context.providers.rubiconFastlane && adProviderRubiconFastlane.canHandleSlot(slotName)) {
			providerList.push(adProviderRubiconFastlane);
		} else {
			providerList.push(adProviderLiftium);
		}

		return providerList;
	}

	return {
		getDecorators: getDecorators,
		getProviderList: getProviderList
	};
});
