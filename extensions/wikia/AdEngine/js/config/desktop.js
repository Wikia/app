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
	'ext.wikia.adEngine.provider.evolve',
	'ext.wikia.adEngine.provider.evolve2',
	'ext.wikia.adEngine.provider.liftium',
	'ext.wikia.adEngine.provider.monetizationService',
	'ext.wikia.adEngine.provider.remnantGpt',
	'ext.wikia.adEngine.provider.sevenOneMedia',
	'ext.wikia.adEngine.provider.turtle',
	'ext.wikia.adEngine.provider.recirculation',
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
	adProviderEvolve,
	adProviderEvolve2,
	adProviderLiftium,
	adProviderMonetizationService,
	adProviderRemnantGpt,
	adProviderSevenOneMedia,
	adProviderTurtle,
	adProviderRecirculation,
	adProviderTaboola
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adConfigLate',
		country = geo.getCountryCode(),
		evolveCountry = (country === 'AU' || country === 'CA' || country === 'NZ'),
		context = adContext.getContext(),
		liftiumSlotsToShowWithSevenOneMedia = {
			'WIKIA_BAR_BOXAD_1': true,
			'TOP_BUTTON_WIDE': true,
			'TOP_BUTTON_WIDE.force': true
		},
		ie8 = window.navigator && window.navigator.userAgent && window.navigator.userAgent.match(/MSIE [6-8]\./),
		gptEnabled = !instantGlobals.wgSitewideDisableGpt;

	function getDecorators() {
		return [adDecoratorPageDimensions];
	}

	function getProviderList(slotName) {
		var providerList = [];

		log('getProvider', 5, logGroup);
		log(slotName, 5, logGroup);

		// Recirculation is not advertising, even if we're using AdEngine. So we show it even if $wgShowAds is false
		if (adProviderRecirculation && adProviderRecirculation.canHandleSlot(slotName) && !context.opts.noExternals) {
			return [adProviderRecirculation];
		}

		// If wgShowAds set to false, hide slots
		if (!context.opts.showAds) {
			return [];
		}

		// Force Turtle
		if (context.forcedProvider === 'turtle') {
			log(['getProvider', slotName, 'Turtle (wgAdDriverForcedProvider)'], 'info', logGroup);
			return [adProviderTurtle];
		}

		// Force Evolve2
		if (context.forcedProvider === 'evolve2') {
			log(['getProvider', slotName, 'Evolve (wgAdDriverForcedProvider)'], 'info', logGroup);
			return [adProviderEvolve2];
		}

		// Force Liftium
		if (context.forcedProvider === 'liftium') {
			log(['getProvider', slotName, 'Liftium (wgAdDriverForcedProvider)'], 'info', logGroup);
			return [adProviderLiftium];
		}

		// SevenOne Media
		if (context.providers.sevenOneMedia) {
			if (!liftiumSlotsToShowWithSevenOneMedia[slotName]) {
				if (ie8) {
					log('SevenOneMedia not supported on IE8. No ads', 'warn', logGroup);
					return [];
				}

				if (instantGlobals.wgSitewideDisableSevenOneMedia) {
					log('SevenOneMedia disabled by DR. No ads', 'warn', logGroup);
					return [];
				}

				return [adProviderSevenOneMedia];
			}
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

		// First provider: Turtle, Evolve or Direct GPT?
		if (context.providers.turtle && adProviderTurtle.canHandleSlot(slotName)) {
			providerList.push(adProviderTurtle);
		} else if (context.providers.evolve2 && adProviderEvolve2.canHandleSlot(slotName)) {
			providerList.push(adProviderEvolve2);
		} else if (evolveCountry && adProviderEvolve.canHandleSlot(slotName)) {
			providerList.push(adProviderEvolve);
		} else if (gptEnabled) {
			providerList.push(adProviderDirectGpt);
		}

		// Second provider: Remnant GPT
		if (gptEnabled) {
			providerList.push(adProviderRemnantGpt);
		}

		// Last resort provider: Liftium
		providerList.push(adProviderLiftium);

		return providerList;
	}

	return {
		getDecorators: getDecorators,
		getProviderList: getProviderList
	};
});
