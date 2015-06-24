/*global describe, it, modules, expect*/
describe('ext.wikia.adEngine.config.mobile', function () {
	'use strict';

	var adProviderDirectMock = {
			name: 'GptMobileMock',
			canHandleSlot: function () { return true; }
		},
		adProviderPaidAssetDropMock = {
			name: 'PaidAssetDropMock',
			canHandleSlot: function () { return false; }
		},
		adProviderRemnantMock = {
			name: 'RemnantGptMobileMock',
			canHandleSlot: function () { return true; }
		},
		adProviderOpenXMock = {
			name: 'OpenX',
			canHandleSlot: function () { return true; }
		};

	function mockAdContext(showAds, enableInvisibleHighImpactSlot, providers) {
		return {
			getContext: function () {
				return {
					opts: {
						showAds: showAds,
						pageType: 'all_ads'
					},
					slots: {
						invisibleHighImpact: enableInvisibleHighImpactSlot
					},
					providers: providers || {},
					forceProviders: {}
				};
			}
		};
	}

	it('getProviderList returns DirectGPT, RemnantGPT in the regular case', function () {
		var adConfigMobile = modules['ext.wikia.adEngine.config.mobile'](
			mockAdContext(true),
			adProviderDirectMock,
			adProviderOpenXMock,
			adProviderPaidAssetDropMock,
			adProviderRemnantMock
		);

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock, adProviderRemnantMock]);
	});

	it('getProviderLists returns [] when showAds is false', function () {
		var adConfigMobile = modules['ext.wikia.adEngine.config.mobile'](
			mockAdContext(false),
			adProviderDirectMock,
			adProviderOpenXMock,
			adProviderPaidAssetDropMock,
			adProviderRemnantMock
		);

		expect(adConfigMobile.getProviderList('foo')).toEqual([]);
	});

	it('getProviderList returns DirectGPT, RemnantGPT for high impact slot', function () {
		var adConfigMobile = modules['ext.wikia.adEngine.config.mobile'](
			mockAdContext(true, true),
			adProviderDirectMock,
			adProviderOpenXMock,
			adProviderPaidAssetDropMock,
			adProviderRemnantMock
		);

		expect(adConfigMobile.getProviderList('INVISIBLE_HIGH_IMPACT')).toEqual([adProviderDirectMock, adProviderRemnantMock]);
	});

	it('getProviderLists returns [] for high impact slot when high impact slot is turned off', function () {
		var adConfigMobile = modules['ext.wikia.adEngine.config.mobile'](
			mockAdContext(true, false),
			adProviderDirectMock,
			adProviderOpenXMock,
			adProviderPaidAssetDropMock,
			adProviderRemnantMock
		);

		expect(adConfigMobile.getProviderList('INVISIBLE_HIGH_IMPACT')).toEqual([]);
	});

	it('getProviderLists returns DirectGPT, RemnantGPT, OpenX when OpenX provider is turned on', function () {
		var adConfigMobile = modules['ext.wikia.adEngine.config.mobile'](
			mockAdContext(true, false, {
				openX: true
			}),
			adProviderDirectMock,
			adProviderOpenXMock,
			adProviderPaidAssetDropMock,
			adProviderRemnantMock
		);

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock, adProviderRemnantMock, adProviderOpenXMock]);
	});

	it('getProviderLists returns DirectGPT, RemnantGPT when OpenX provider is turned on but cannot handle slot', function () {
		spyOn(adProviderOpenXMock, 'canHandleSlot').and.returnValue(false);
		var adConfigMobile = modules['ext.wikia.adEngine.config.mobile'](
			mockAdContext(true, false, {
				openX: true
			}),
			adProviderDirectMock,
			adProviderOpenXMock,
			adProviderPaidAssetDropMock,
			adProviderRemnantMock
		);

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock, adProviderRemnantMock]);
	});
});
