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
		adProviderHitMediaMock = {
			name: 'HitMedia',
			canHandleSlot: function () {
				return true;
			}
		},
		adProviderPaidAssetDropMock = {
			name: 'PaidAssetDropMock',
			canHandleSlot: function () {
				return false;
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
			adProviderHitMediaMock,
			adProviderPaidAssetDropMock,
			adProviderRemnantMock,
			adProviderRubiconFastlaneMock,
			mocks.instantGlobals
		);
	}

	it('getProviderList returns DirectGPT, RemnantGPT in the regular case', function () {
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock, adProviderRemnantMock]);
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

	it('getProviderLists returns HitMedia, RemnantGPT when hitMedia is enabled', function () {
		context.providers.hitMedia = true;
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderHitMediaMock, adProviderRemnantMock]);
	});

	it('getProviderLists returns DirectGpt, RemnantGPT when evolve is enabled but cannot handle the slot', function () {
		spyOn(adProviderEvolveMock, 'canHandleSlot').and.returnValue(false);
		context.providers.evolve2 = true;
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock, adProviderRemnantMock]);
	});

	it('getProviderLists returns DirectGpt, RemnantGPT when hitMedia is enabled but cant handle the slot', function () {
		spyOn(adProviderHitMediaMock, 'canHandleSlot').and.returnValue(false);
		context.providers.hitMedia = true;
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock, adProviderRemnantMock]);
	});

	it('getProviderLists returns Evolve2 when force provider is set', function () {
		context.forcedProvider = 'evolve2';
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderEvolveMock]);
	});

	it('getProviderLists returns HitMedia when force provider is set', function () {
		context.forcedProvider = 'hitmedia';
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderHitMediaMock]);
	});

	it('getProviderLists returns Direct, Remnant when RPFL is disabled', function () {
		spyOn(adProviderRubiconFastlaneMock, 'canHandleSlot').and.returnValue(false);
		context.providers.rubiconFastlane = true;

		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock, adProviderRemnantMock]);
	});

	it('getProviderLists returns Direct, Remnant, RubiconFastlane', function () {
		context.providers.rubiconFastlane = true;

		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([
			adProviderDirectMock,
			adProviderRemnantMock,
			adProviderRubiconFastlaneMock
		]);
	});

	it('getProviderLists returns RubiconFastlane when wgSitewideDisableGpt is enabled', function () {
		mocks.instantGlobals.wgSitewideDisableGpt = true;
		context.providers.rubiconFastlane = true;

		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderRubiconFastlaneMock]);
	});
});
