/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.config.mobile', function () {
	'use strict';

	var adProviderDirectMock = {
			name: 'GptMobileMock',
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

	it('getProviderLists returns DirectGpt, RemnantGPT when directGpt is enabled', function () {
		context.providers.directGpt = true;
		var adConfigMobile = getConfig();

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock, adProviderRemnantMock]);
	});
});
