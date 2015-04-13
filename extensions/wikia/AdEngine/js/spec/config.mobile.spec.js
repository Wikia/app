/*global describe, it, modules, expect*/
describe('ext.wikia.adEngine.config.mobile', function () {
	'use strict';

	var adProviderDirectMock = {
			name: 'GptMobileMock',
			canHandleSlot: function () { return true; }
		},
		adProviderRemnantMock = {
			name: 'RemnantGptMobileMock',
			canHandleSlot: function () { return true; }
		},
		adProviderOpenXMock = {
			name: 'OpenX',
			canHandleSlot: function () { return true; }
		};

	function mockAdContext(showAds) {
		return {
			getContext: function () {
				return {
					opts: {
						showAds: showAds,
						pageType: 'all_ads'
					},
					providers: {},
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
			adProviderRemnantMock
		);

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock, adProviderRemnantMock]);
	});

	it('getProviderLists returns [] when showAds is false', function () {
		var adConfigMobile = modules['ext.wikia.adEngine.config.mobile'](
			mockAdContext(false),
			adProviderDirectMock,
			adProviderOpenXMock,
			adProviderRemnantMock
		);

		expect(adConfigMobile.getProviderList('foo')).toEqual([]);
	});
});
