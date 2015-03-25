/*global describe, it, modules, expect*/
describe('AdConfigMobile', function () {
	'use strict';

	var adProviderDirectMock = {
			name: 'GptMobileMock',
			canHandleSlot: function () { return true; }
		},
		adProviderRemnantMock = {
			name: 'RemnantGptMobileMock',
			canHandleSlot: function () { return true; }
		};

	function mockAdContext(showAds, enableRemnantGptMobile) {
		return {
			getContext: function () {
				return {
					opts: {
						showAds: showAds,
						pageType: 'all_ads'
					},
					providers: {
						remnantGptMobile: enableRemnantGptMobile
					}
				};
			}
		};
	}

	it('getProviderList returns DirectGPT, RemnantGPT in the regular case', function () {
		var adConfigMobile = modules['ext.wikia.adEngine.adConfigMobile'](
			mockAdContext(true),
			adProviderDirectMock,
			adProviderRemnantMock
		);

		expect(adConfigMobile.getProviderList('foo')).toEqual([adProviderDirectMock, adProviderRemnantMock], 'GPT');
	});

	it('getProviderLists returns Null when wgShowAds set to false', function () {
		var adConfigMobile = modules['ext.wikia.adEngine.adConfigMobile'](
			mockAdContext(false),
			adProviderDirectMock,
			adProviderRemnantMock
		);

		expect(adConfigMobile.getProviderList('foo')).toEqual([], 'Null over GPT');
	});
});
