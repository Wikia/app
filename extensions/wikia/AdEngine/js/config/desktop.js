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
	'ext.wikia.adEngine.provider.remnantGpt',
	'ext.wikia.adEngine.provider.turtle'
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
	adProviderRemnantGpt,
	adProviderTurtle
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adConfigLate',
		context = adContext.getContext(),
		gptEnabled = !instantGlobals.wgSitewideDisableGpt,
		forcedProviders = {
			evolve2:  [adProviderEvolve2],
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

		// First provider: Turtle, Evolve or Direct GPT?
		if (context.providers.turtle && adProviderTurtle.canHandleSlot(slotName)) {
			providerList.push(adProviderTurtle);
		} else if (context.providers.evolve2 && adProviderEvolve2.canHandleSlot(slotName)) {
			providerList.push(adProviderEvolve2);
		} else if (gptEnabled) {
			providerList.push(adProviderDirectGpt);

			if (context.opts.premiumOnly) {
				return providerList;
			}
		}

		// Second provider: Remnant GPT
		if (gptEnabled) {
			providerList.push(adProviderRemnantGpt);
		}

		return providerList;
	}

	return {
		getDecorators: getDecorators,
		getProviderList: getProviderList
	};
});
