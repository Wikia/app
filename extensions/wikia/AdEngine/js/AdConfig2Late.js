/*global define,require*/
define('ext.wikia.adEngine.adConfigLate', [
	// regular dependencies
	'wikia.log',
	'wikia.window',
	'wikia.instantGlobals',
	'wikia.geo',
	'ext.wikia.adEngine.adContext',

	// adProviders
	'ext.wikia.adEngine.provider.evolve',
	'ext.wikia.adEngine.provider.liftium',
	'ext.wikia.adEngine.provider.directGpt',
	'ext.wikia.adEngine.provider.remnantGpt',
	'ext.wikia.adEngine.provider.sevenOneMedia',
	require.optional('ext.wikia.adEngine.provider.taboola'),

	require.optional('ext.wikia.adEngine.adDecoratorTopInContent')
], function (
	// regular dependencies
	log,
	window,
	instantGlobals,
	geo,
	adContext,

	// AdProviders
	adProviderEvolve,
	adProviderLiftium,
	adProviderDirectGpt,
	adProviderRemnantGpt,
	adProviderSevenOneMedia, // TODO: move this to the early queue (remove jQuery dependency first)
	adProviderTaboola,

	adDecoratorTopInContent
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adConfigLate',
		country = geo.getCountryCode(),
		context = adContext.getContext(),
		liftiumSlotsToShowWithSevenOneMedia = {
			'WIKIA_BAR_BOXAD_1': true,
			'TOP_BUTTON_WIDE': true,
			'TOP_BUTTON_WIDE.force': true
		},
		ie8 = window.navigator && window.navigator.userAgent && window.navigator.userAgent.match(/MSIE [6-8]\./),

		dartDirectBtfSlots = {
			'LEFT_SKYSCRAPER_3': true,
			'PREFOOTER_LEFT_BOXAD': true,
			'PREFOOTER_RIGHT_BOXAD': true,
			'TOP_INCONTENT_BOXAD': true
		},
		alwaysCallDart = context.opts.alwaysCallDart && !instantGlobals.wgSitewideDisableGpt,
		decorators = adDecoratorTopInContent ? [adDecoratorTopInContent] : [];

	function getProviderList(slotname) {
		log('getProvider', 5, logGroup);
		log(slotname, 5, logGroup);

		if (context.forceProviders.liftium) {
			return [adProviderLiftium];
		}

		// First ask SevenOne Media
		if (context.providers.sevenOneMedia) {
			if (!liftiumSlotsToShowWithSevenOneMedia[slotname]) {
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

		if (context.providers.taboola && adProviderTaboola && adProviderTaboola.canHandleSlot(slotname)) {
			return [adProviderTaboola];
		}

		if (country === 'AU' || country === 'CA' || country === 'NZ') {
			log(['getProvider', slotname, 'Evolve'], 'info', logGroup);
			return [adProviderEvolve, adProviderLiftium];
		}

		// Don't load ads in TOP_INCONTENT_BOXAD if adDecoratorTopInContent is not available
		if (slotname === 'TOP_INCONTENT_BOXAD' && !adDecoratorTopInContent) {
			return [];
		}

		if (alwaysCallDart) {
			if (dartDirectBtfSlots[slotname]) {
				return [adProviderDirectGpt, adProviderRemnantGpt, adProviderLiftium];
			}
			return [adProviderRemnantGpt, adProviderLiftium];
		}

		// Load GPT and Liftium ads in TOP_INCONTENT_BOXAD
		if (slotname === 'TOP_INCONTENT_BOXAD') {
			return [adProviderDirectGpt, adProviderLiftium];
		}

		if (context.targeting.skin === 'venus' && slotname === 'INCONTENT_BOXAD_1') {
			return [];
		}

		return [adProviderLiftium];
	}

	return {
		getDecorators: function () { return decorators; },
		getProviderList: getProviderList
	};
});
