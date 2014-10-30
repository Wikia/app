/*global describe, it, expect, modules*/
describe('AdConfig2Late', function () {
	'use strict';

	var uaIE8 = [
		'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0;',
		'GTB7.4; InfoPath.2; SV1; .NET CLR 3.3.69573; WOW64; en-US)'
	].join('');

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


	it('getProvider returns Liftium if it can handle it', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () {return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true; }},
			logMock = function () {},
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
			adProviderTaboola,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProviderList(['foo'])[0]).toBe(adProviderLiftiumMock, 'adProviderLiftiumMock');
	});

	it('getProvider returns SevenOneMedia if it can handle it (for wgAdDriverUseSevenOneMedia) Poland', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () {return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true; }},
			logMock = function () {},
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
			adProviderTaboola,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProviderList(['foo'])[0]).toBe(adProviderSevenOneMedia, 'adProviderSevenOneMediaMock');
	});

	it('getProvider returns RemnantGpt when context.opts.alwaysCallDart = true', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return true; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () {return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true; }},
			logMock = function () { return; },
			windowMock = {},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'XX'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext({}, {}, {alwaysCallDart: true}),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderTaboola,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProviderList(['foo'])[0]).toBe(adProviderRemnantGpt, 'adProviderRemnantGpt');
	});

	it('getProvider returns SevenOneMedia if it can handle it (for wgAdDriverUseSevenOneMedia) Australia', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () {return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true; }},
			logMock = function () {},
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
			adProviderTaboola,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProviderList(['foo'])[0]).toBe(adProviderSevenOneMedia, 'adProviderSevenOneMediaMock');
	});

	it('getProvider returns [] for 71M disaster recovery with wgAdDriverUseSevenOneMedia', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () {return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true; }},
			logMock = function () {},
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
			adProviderTaboola,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProviderList(['foo'])[0]).toBeUndefined();
	});

	it('getProvider returns Liftium for 71M disaster recovery without wgAdDriverUseSevenOneMedia', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () {return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true; }},
			logMock = function () {},
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
			adProviderTaboola,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProviderList(['foo'])[0]).toBe(adProviderLiftiumMock, 'adProviderLiftiumMock');
	});

	it('getProvider returns [] for IE8 with wgAdDriverUseSevenOneMedia', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () {return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true; }},
			logMock = function () {},
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
			adProviderTaboola,
			adProviderSevenOneMedia
		);
		expect(adConfig.getProviderList(['foo'])[0]).toBeUndefined();
	});

	it('getProvider returns Liftium for IE8 without wgAdDriverUseSevenOneMedia', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () {return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true; }},
			logMock = function () {},
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
			adProviderTaboola,
			adProviderSevenOneMedia
		);
		expect(adConfig.getProviderList(['foo'])[0]).toBe(adProviderLiftiumMock, 'adProviderLiftiumMock');
	});

	it('getProvider returns Liftium without AbTest', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () {return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true; }},
			logMock = function () {},
			windowMock = {wgAdDriverUseSevenOneMedia: false},
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
			adProviderTaboola,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProviderList(['foo'])[0]).toBe(adProviderLiftiumMock, 'adProviderLiftiumMock');
	});

	it('getProvider returns DirectGpt for context.opts.alwaysCallDart for given slots', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () {return true; }},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true; }},
			logMock = function () { return; },
			windowMock = {},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () {return 'XX'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			mockAdContext({}, {}, {alwaysCallDart: true}),
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProviderList(['foo'])[0]).not.toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProviderList(['MODAL_INTERSTITIAL'])[0]).not.toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProviderList(['LEFT_SKYSCRAPER_3'])[0]).toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProviderList(['PREFOOTER_LEFT_BOXAD'])[0]).toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProviderList(['PREFOOTER_RIGHT_BOXAD'])[0]).toBe(adProviderDirectGpt, 'adProviderDirectGpt');
	});

	it('getProvider returns Taboola US wikis on article pages when wgAdDriverUseTaboola enabled', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () {return true;}, init: function(){}},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true; }},
			logMock = function () {},
			windowMock = {},
			instantGlobalsMock = {},
			abTestMock = { inGroup: function () {return true;} },
			geoMock = { getCountryCode: function () {return 'US';} },
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
			adProviderTaboola,
			adProviderSevenOneMedia,
			abTestMock
		);

		expect(adConfig.getProviderList(['NATIVE_TABOOLA'])[0]).toBe(adProviderTaboola, 'adProviderTaboola');

	});
	it('getProvider returns Taboola US wikis on home pages when wgAdDriverUseTaboola enabled', function () {
		var adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true; }},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true; }},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false; }},
			adProviderTaboola = {name: 'Taboola', canHandleSlot: function () {return true;}, init: function(){}},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true; }},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true; }},
			logMock = function () {},
			windowMock = {},
			instantGlobalsMock = {},
			abTestMock = { inGroup: function () {return true;} },
			geoMock = { getCountryCode: function () {return 'US';} },
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
			adProviderTaboola,
			adProviderSevenOneMedia,
			abTestMock
		);

		expect(adConfig.getProviderList(['NATIVE_TABOOLA'])[0]).toBe(adProviderTaboola, 'adProviderTaboola');

	});

});
