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
	'ext.wikia.adEngine.provider.null',
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
	adProviderNull,
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
		slotsToAlwaysCallRemnantGpt = {
			'WIKIA_BAR_BOXAD_1': true
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
		taboolaEnabled = country === 'US' &&
			(targeting.pageType === 'article' || targeting.pageType === 'home') &&
			taboolaEnabledWikis[targeting.wikiDbName] &&
			context.providers.taboola &&
			abTest && abTest.inGroup('NATIVE_ADS_TABOOLA', 'YES'),

		dartBtfCountries = {
			US: true
		},
		dartBtfSlots = {
			INCONTENT_BOXAD_1: true,
			LEFT_SKYSCRAPER_3: true,
			PREFOOTER_LEFT_BOXAD: true,
			PREFOOTER_RIGHT_BOXAD: true
		},

		dartBtfEnabled = dartBtfCountries[country] && context.opts.useDartForSlotsBelowTheFold,

		alwaysCallDartInCountries = instantGlobals.wgAdDriverAlwaysCallDartInCountries || [],
		alwaysCallDart = (alwaysCallDartInCountries.indexOf(country) > -1);

	function getProvider(slot) {
		var slotname = slot[0],
			useRemnantGpt = alwaysCallDart || context.providers.remnantGpt || slotsToAlwaysCallRemnantGpt[slotname];

		log('getProvider', 5, logGroup);
		log(slot, 5, logGroup);


		if (slot[2] === 'Evolve') {
			log(['getProvider', slot, 'Evolve'], 'info', logGroup);
			return adProviderEvolve;
		}

		if (slot[2] === 'Liftium' || context.forceProviders.liftium) {
			if (adProviderLiftium.canHandleSlot(slotname)) {
				return adProviderLiftium;
			}
			log('#' + slotname + ' disabled. Forced Liftium, but it can\'t handle it', 7, logGroup);
			return adProviderNull;
		}

		// First ask SevenOne Media
		if (context.providers.sevenOneMedia) {
			if (adProviderSevenOneMedia.canHandleSlot(slotname)) {
				if (ie8) {
					log('SevenOneMedia not supported on IE8. Using Null provider instead', 'warn', logGroup);
					return adProviderNull;
				}

				if (instantGlobals.wgSitewideDisableSevenOneMedia) {
					log('SevenOneMedia disabled by DR. Using Null provider instead', 'warn', logGroup);
					return adProviderNull;
				}

				return adProviderSevenOneMedia;
			}

			if (!liftiumSlotsToShowWithSevenOneMedia[slot[0]]) {
				return adProviderNull;
			}
		}

		if (country === 'AU' || country === 'CA' || country === 'NZ') {
			if (adProviderEvolve.canHandleSlot(slotname)) {
				log(['getProvider', slot, 'Evolve'], 'info', logGroup);
				return adProviderEvolve;
			}
		}

		if (taboolaEnabled && adProviderTaboola.canHandleSlot(slotname)) {
			return adProviderTaboola;
		}

		// DART for some slots below the fold a.k.a. coffee cup
		if (dartBtfEnabled && dartBtfSlots[slotname] && adProviderDirectGpt.canHandleSlot(slotname)) {
			return adProviderDirectGpt;
		}

		if (useRemnantGpt && adProviderRemnantGpt.canHandleSlot(slotname)) {
			return adProviderRemnantGpt;
		}

		if (adProviderLiftium.canHandleSlot(slotname) && !instantGlobals.wgSitewideDisableLiftium) {
			return adProviderLiftium;
		}

		return adProviderNull;
	}

	return {
		getDecorators: function () { return; },
		getProvider: getProvider
	};
});
