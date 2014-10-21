// TODO: ADEN-1332-ize after ADEN-1326
/*global define,require*/
define('ext.wikia.adEngine.adConfigLate', [
	// regular dependencies
	'wikia.log',
	'wikia.window',
	'wikia.instantGlobals',
	'wikia.geo',

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
		liftiumSlotsToShowWithSevenOneMedia = {
			'WIKIA_BAR_BOXAD_1': true,
			'TOP_BUTTON_WIDE': true,
			'TOP_BUTTON_WIDE.force': true
		},
		slotsToAlwaysCallRemnantGpt = {
			'WIKIA_BAR_BOXAD_1': true
		},
		countriesToAlwaysCallRemnantGpt = {
			'UK': true,
			'GB': true
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
			(window.wikiaPageType === 'article' || window.wikiaPageType === 'home') &&
			taboolaEnabledWikis[window.wgDBname] &&
			window.wgAdDriverUseTaboola &&
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
		dartBtfVerticals = {
			Entertainment: true,
			Gaming: true
		},

		dartBtfEnabled = dartBtfCountries[country] && (
				window.wgAdDriverUseDartForSlotsBelowTheFold === true ||
				(window.wgAdDriverUseDartForSlotsBelowTheFold && dartBtfVerticals[window.cscoreCat])
			);

	function getProvider(slot) {
		var slotname = slot[0],
			useRemnantGpt = window.wgAdDriverUseRemnantGpt ||
				slotsToAlwaysCallRemnantGpt[slotname] ||
				countriesToAlwaysCallRemnantGpt[country];

		log('getProvider', 5, logGroup);
		log(slot, 5, logGroup);


		if (slot[2] === 'Evolve') {
			log(['getProvider', slot, 'Evolve'], 'info', logGroup);
			return adProviderEvolve;
		}

		if (slot[2] === 'Liftium' || window.wgAdDriverForceLiftiumAd) {
			if (adProviderLiftium.canHandleSlot(slotname)) {
				return adProviderLiftium;
			}
			log('#' + slotname + ' disabled. Forced Liftium, but it can\'t handle it', 7, logGroup);
			return adProviderNull;
		}

		// First ask SevenOne Media
		if (window.wgAdDriverUseSevenOneMedia) {
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
		getDecorators: function () {},
		getProvider: getProvider
	};
});
