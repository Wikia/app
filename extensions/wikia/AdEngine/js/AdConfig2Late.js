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
	'ext.wikia.adEngine.provider.taboola',
	'ext.wikia.adEngine.provider.sevenOneMedia',
	require.optional('wikia.abTest')
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
	adProviderTaboola,
	adProviderSevenOneMedia, // TODO: move this to the early queue (remove jQuery dependency first)
	abTest
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adConfigLate',
		country = geo.getCountryCode(),
		context = adContext.getContext(),
		targeting = context.targeting,
		liftiumSlotsToShowWithSevenOneMedia = {
			'WIKIA_BAR_BOXAD_1': true,
			'TOP_BUTTON_WIDE': true,
			'TOP_BUTTON_WIDE.force': true
		},
		ie8 = window.navigator && window.navigator.userAgent && window.navigator.userAgent.match(/MSIE [6-8]\./),

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
			abTest && abTest.inGroup('NATIVE_ADS_TABOOLA', 'YES'),

		dartDirectBtfSlots = {
			INCONTENT_BOXAD_1: true,
			LEFT_SKYSCRAPER_3: true,
			PREFOOTER_LEFT_BOXAD: true,
			PREFOOTER_RIGHT_BOXAD: true,
			WIKIA_BAR_BOXAD_1: true
		},

		alwaysCallDartInSlots = {
			'WIKIA_BAR_BOXAD_1': true
		},
		alwaysCallDart = context.opts.alwaysCallDart;

	function getProviderList(slotname) {
		var callDart = alwaysCallDart || alwaysCallDartInSlots[slotname];

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

		if (taboolaEnabled && adProviderTaboola.canHandleSlot(slotname)) {
			return [adProviderTaboola];
		}

		if (country === 'AU' || country === 'CA' || country === 'NZ') {
			log(['getProvider', slotname, 'Evolve'], 'info', logGroup);
			return [adProviderEvolve, adProviderLiftium];
		}

		if (callDart) {
			if (dartDirectBtfSlots[slotname]) {
				return [adProviderDirectGpt, adProviderRemnantGpt, adProviderLiftium];
			}
			return [adProviderRemnantGpt, adProviderLiftium];
		}

		return [adProviderLiftium];
	}

	return {
		getDecorators: function () { return []; },
		getProviderList: getProviderList
	};
});
