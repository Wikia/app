/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.config.mobile', function () {
	'use strict';

	var adProviderDirectMock = {
			name: 'GptMobileMock',
			canHandleSlot: function () {
				return true;
			}
		},
		adProviderEvolveMock = {
			name: 'Evolve2',
			canHandleSlot: function () {
				return true;
			}
		},
		adProviderRemnantMock = {
			name: 'RemnantGptMobileMock',
			canHandleSlot: function () {
				return true;
			}
		},
		adProviderRubiconFastlaneMock = {
			name: 'RubiconFastlaneMock',
			canHandleSlot: function () {
				return true;
			}
		},
		context = {},
		mocks = {
			adContext: {
				getContext: function () {
					return context;
				}
			},
			instantGlobals: {}
		};

	beforeEach(function () {
		context = {
			opts: {
				showAds: true,
				pageType: 'all_ads'
			},
			slots: {
				invisibleHighImpact: false
			},
			providers: {},
			forcedProvider: null
		};
		mocks.instantGlobals = {};
	});

	function getConfig() {
		return modules['ext.wikia.adEngine.config.mobile'](
			mocks.adContext,
			adProviderDirectMock,
			adProviderEvolveMock,
			adProviderRemnantMock,
			adProviderRubiconFastlaneMock,
			mocks.instantGlobals
		);
	}

	it('getProviderList returns DirectGPT, RemnantGPT in the regular case', function () {
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock, adProviderRemnantMock]);
	});

	it('getProviderList returns DirectGPT on premium-only page', function () {
		context.opts.premiumOnly = true;
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock]);
	});

	it('getProviderLists returns [] when showAds is false', function () {
		context.opts.showAds = false;
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([]);
	});

	it('getProviderList returns DirectGPT, RemnantGPT for high impact slot', function () {
		context.slots.invisibleHighImpact = true;
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('INVISIBLE_HIGH_IMPACT'))
			.toEqual([adProviderDirectMock, adProviderRemnantMock]);
	});

	it('getProviderLists returns [] for high impact slot when high impact slot is turned off', function () {
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('INVISIBLE_HIGH_IMPACT')).toEqual([]);
	});

	it('getProviderLists returns Evolve2, RemnantGPT when evolve is enabled', function () {
		context.providers.evolve2 = true;
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderEvolveMock, adProviderRemnantMock]);
	});

	it('getProviderLists returns DirectGpt, RemnantGPT when directGpt is enabled', function () {
		context.providers.directGpt = true;
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock, adProviderRemnantMock]);
	});

	it('getProviderLists returns DirectGpt, RemnantGPT when evolve is enabled but cannot handle the slot', function () {
		spyOn(adProviderEvolveMock, 'canHandleSlot').and.returnValue(false);
		context.providers.evolve2 = true;
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock, adProviderRemnantMock]);
	});

	it('getProviderLists returns DirectGpt, RemnantGPT when evolve is enabled but cant handle the slot', function () {
		spyOn(adProviderEvolveMock, 'canHandleSlot').and.returnValue(false);
		context.providers.evolve2 = true;
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock, adProviderRemnantMock]);
	});

	it('getProviderLists returns Evolve2 when force provider is set', function () {
		context.forcedProvider = 'evolve2';
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderEvolveMock]);
	});
});
