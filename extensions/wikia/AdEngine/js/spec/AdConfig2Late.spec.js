/*global describe, it, expect, modules, spyOn*/
/*jshint maxlen:200*/
describe('AdConfig2Late', function () {
	'use strict';

	var uaIE8 = [
		'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0;',
		'GTB7.4; InfoPath.2; SV1; .NET CLR 3.3.69573; WOW64; en-US)'
	].join('');

	function noop() {
		return;
	}

	function mockAdContext(targeting, providers, opts) {
		var defaultTargeting = { pageType: 'article' };
		return {
			getContext: function () {
				return {
					opts: opts || {},
					targeting: targeting || defaultTargeting,
					providers: providers || {},
					forceProviders: {}
				};
			}
		};
	}


	it('getProvider returns Evolve in CA AU NZ counties', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () { return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () { return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () { return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () { return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () { return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () { return true; }},
			logMock = noop,
			windowMock = {},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'CA'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext(),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderSevenOneMedia,
			adProviderTaboola
		);

		expect(adConfig.getProviderList('foo')).toEqual([adProviderEvolveMock, adProviderRemnantGpt, adProviderLiftiumMock], 'adProviderEvolveMock');
	});

	it('getProvider returns DirectGpt in CA AU NZ counties for non Evolve slots if slotname in dartDirectBtfSlots', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () { return false; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () { return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () { return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () { return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () { return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () { return true; }},
			logMock = noop,
			windowMock = {},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'CA'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext(),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderSevenOneMedia,
			adProviderTaboola
		);

		expect(adConfig.getProviderList('PREFOOTER_LEFT_BOXAD')).toEqual([adProviderDirectGpt, adProviderRemnantGpt, adProviderLiftiumMock], 'adProviderDirectGpt');
	});

	it('getProvider returns RemnantGpt in CA AU NZ counties for non Evolve slots if slotname not in dartDirectBtfSlots', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () { return false; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () { return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () { return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () { return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () { return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () { return true; }},
			logMock = noop,
			windowMock = {},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'CA'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext(),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderSevenOneMedia,
			adProviderTaboola
		);

		expect(adConfig.getProviderList('SOME_OTHER_SLOT')).toEqual([adProviderRemnantGpt, adProviderLiftiumMock], 'adProviderRemnantGpt');
	});

	it('getProvider returns Liftium if it can handle it', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () { return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () { return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () { return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () { return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () { return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () { return true; }},
			logMock = noop,
			windowMock = {},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'PL'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext(),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderSevenOneMedia,
			adProviderTaboola
		);

		expect(adConfig.getProviderList('foo')).toEqual([adProviderRemnantGpt, adProviderLiftiumMock], 'adProviderLiftiumMock');
	});

	it('getProvider returns SevenOneMedia if it can handle it (for wgAdDriverUseSevenOneMedia) Poland', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () { return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () { return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () { return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () { return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () { return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () { return true; }},
			logMock = noop,
			windowMock = {},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'PL'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext(null, {sevenOneMedia: true}),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderSevenOneMedia,
			adProviderTaboola
		);

		expect(adConfig.getProviderList('foo')).toEqual([adProviderSevenOneMedia], 'adProviderSevenOneMediaMock');
	});

	it('getProvider returns SevenOneMedia if it can handle it (for wgAdDriverUseSevenOneMedia) Australia', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () { return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () { return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () { return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () { return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () { return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () { return true; }},
			logMock = noop,
			windowMock = {},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'AU'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext(null, {sevenOneMedia: true}),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderSevenOneMedia,
			adProviderTaboola
		);

		expect(adConfig.getProviderList('foo')).toEqual([adProviderSevenOneMedia], 'adProviderSevenOneMediaMock');
	});

	it('getProvider returns [] for 71M disaster recovery with wgAdDriverUseSevenOneMedia', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () { return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () { return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () { return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () { return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () { return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () { return true; }},
			logMock = noop,
			windowMock = {},
			instantGlobalsMock = {wgSitewideDisableSevenOneMedia: true},
			geoMock = { getCountryCode: function () { return 'PL'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext(null, {sevenOneMedia: true}),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderSevenOneMedia,
			adProviderTaboola
		);

		expect(adConfig.getProviderList('foo')).toEqual([]);
	});

	it('getProvider returns Liftium for 71M disaster recovery without wgAdDriverUseSevenOneMedia', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () { return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () { return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () { return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () { return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () { return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () { return true; }},
			logMock = noop,
			windowMock = {},
			instantGlobalsMock = {wgSitewideDisableSevenOneMedia: true},
			geoMock = { getCountryCode: function () { return 'PL'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext(),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderSevenOneMedia,
			adProviderTaboola
		);

		expect(adConfig.getProviderList('foo')).toEqual([adProviderRemnantGpt, adProviderLiftiumMock], 'adProviderLiftiumMock');
	});

	it('getProvider returns [] for IE8 with wgAdDriverUseSevenOneMedia', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () { return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () { return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () { return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () { return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () { return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () { return true; }},
			logMock = noop,
			windowMock = {navigator: {userAgent: uaIE8}},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'PL'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext(null, {sevenOneMedia: true}),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderSevenOneMedia,
			adProviderTaboola
		);
		expect(adConfig.getProviderList('foo')).toEqual([]);
	});

	it('getProvider returns Liftium for IE8 without wgAdDriverUseSevenOneMedia', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () { return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () { return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () { return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () { return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () { return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () { return true; }},
			logMock = noop,
			windowMock = {navigator: {userAgent: uaIE8}},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'PL'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext(),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderSevenOneMedia,
			adProviderTaboola
		);
		expect(adConfig.getProviderList('foo')).toEqual([adProviderRemnantGpt, adProviderLiftiumMock], 'adProviderLiftiumMock');
	});

	it('getProvider returns (DirectGpt->)RemnantGpt->Liftium for given slots', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () { return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () { return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () { return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () { return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () { return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () { return true; }},
			logMock = noop,
			windowMock = {},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'XX'; } },
			adConfig,
			expectedProviderListRemnants,
			expectedProviderListDirectAndRemnants;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext(),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderSevenOneMedia,
			adProviderTaboola
		);

		expectedProviderListRemnants = [adProviderRemnantGpt, adProviderLiftiumMock];
		expectedProviderListDirectAndRemnants = [adProviderDirectGpt, adProviderRemnantGpt, adProviderLiftiumMock];

		expect(adConfig.getProviderList('foo')).toEqual(expectedProviderListRemnants, 'foo');
		expect(adConfig.getProviderList('MODAL_INTERSTITIAL')).toEqual(expectedProviderListRemnants, 'MODAL_INTERSTITIAL');
		expect(adConfig.getProviderList('LEFT_SKYSCRAPER_3')).toEqual(expectedProviderListDirectAndRemnants, 'adProviderDirectGpt');
		expect(adConfig.getProviderList('PREFOOTER_LEFT_BOXAD')).toEqual(expectedProviderListDirectAndRemnants, 'adProviderDirectGpt');
		expect(adConfig.getProviderList('PREFOOTER_RIGHT_BOXAD')).toEqual(expectedProviderListDirectAndRemnants, 'adProviderDirectGpt');
	});

	it('getProvider returns Taboola US wikis on article pages when wgAdDriverUseTaboola enabled', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () { return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () { return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () { return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () { return true; }, init: noop},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () { return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () { return true; }},
			logMock = noop,
			windowMock = {},
			instantGlobalsMock = {},
			abTestMock = { inGroup: function (group) { return (group === 'NATIVE_ADS_TABOOLA'); } },
			geoMock = { getCountryCode: function () { return 'XX'; } },
			adConfig;

		spyOn(adProviderTaboola, 'init');

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext({ pageType: 'article', wikiDbName: 'darksouls' }, { taboola: true }),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderSevenOneMedia,
			adProviderTaboola,
			abTestMock
		);

		expect(adConfig.getProviderList(['NATIVE_TABOOLA'])).toEqual([adProviderTaboola], 'adProviderTaboola');
	});

	it('getProvider returns Taboola US wikis on home pages when wgAdDriverUseTaboola enabled', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () { return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () { return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () { return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () { return true; }, init: noop},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () { return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () { return true; }},
			logMock = noop,
			windowMock = {},
			instantGlobalsMock = {},
			abTestMock = { inGroup: function (group) { return (group === 'NATIVE_ADS_TABOOLA'); } },
			geoMock = { getCountryCode: function () { return 'XX'; } },
			adConfig;

		spyOn(adProviderTaboola, 'init');

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext({ pageType: 'home', wikiDbName: 'darksouls' }, { taboola: true }),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderSevenOneMedia,
			adProviderTaboola,
			abTestMock
		);

		expect(adConfig.getProviderList(['NATIVE_TABOOLA'])).toEqual([adProviderTaboola], 'adProviderTaboola');

	});

});
