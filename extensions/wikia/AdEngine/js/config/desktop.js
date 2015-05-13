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
	'ext.wikia.adEngine.provider.evolve',
	'ext.wikia.adEngine.provider.liftium',
	'ext.wikia.adEngine.provider.directGpt',
	'ext.wikia.adEngine.provider.monetizationService',
	'ext.wikia.adEngine.provider.openX',
	'ext.wikia.adEngine.provider.remnantGpt',
	'ext.wikia.adEngine.provider.sevenOneMedia',
	'ext.wikia.adEngine.provider.turtle',
	require.optional('ext.wikia.adEngine.provider.taboola'),
	require.optional('ext.wikia.adEngine.adDecoratorTopInContent')
], function (
	// regular dependencies
	log,
	window,
	instantGlobals,
	geo,
	adContext,
	adDecoratorPageDimensions,

	// AdProviders
	adProviderEvolve,
	adProviderLiftium,
	adProviderDirectGpt,
	adProviderMonetizationService,
	adProviderOpenX,
	adProviderRemnantGpt,
	adProviderSevenOneMedia,
	adProviderTurtle,
	adProviderTaboola,

	adDecoratorTopInContent
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
		dartEnabled = !instantGlobals.wgSitewideDisableGpt;

	function getDecorators() {
		var decorators = [adDecoratorPageDimensions];

		if (adDecoratorTopInContent) {
			decorators.push(adDecoratorTopInContent);
		}

		return decorators;
	}

	function getProviderList(slotName) {
		var providerList = [];

		log('getProvider', 5, logGroup);
		log(slotName, 5, logGroup);

		// If wgShowAds set to false, hide slots
		if (!context.opts.showAds) {
			return [];
		}

		// Force OpenX
		if (context.forceProviders.openX) {
			log(['getProvider', slotName, 'OpenX (wgAdDriverForceOpenXAd)'], 'info', logGroup);
			return [adProviderOpenX];
		}

		if (context.forceProviders.liftium) {
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
		if (context.providers.monetizationService &&
			adProviderMonetizationService && adProviderMonetizationService.canHandleSlot(slotName)
		) {
			if (instantGlobals.wgSitewideDisableMonetizationService) {
				log('MonetizationService disabled by DR. No ads', 'warn', logGroup);
				return [];
			}
			return [adProviderMonetizationService];
		}

		// First provider: Turtle, Evolve or Direct GPT?
		if (context.providers.turtle) {
			providerList.push(adProviderTurtle);
		} else if (evolveCountry && adProviderEvolve.canHandleSlot(slotName)) {
			providerList.push(adProviderEvolve);
		} else if (dartEnabled) {
			providerList.push(adProviderDirectGpt);
		}

		// Second provider: Remnant GPT
		if (dartEnabled) {
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
