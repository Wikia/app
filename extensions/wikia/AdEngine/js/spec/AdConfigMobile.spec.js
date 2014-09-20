/*global describe, it, modules, expect*/
describe('AdConfigMobile', function () {
	'use strict';

	var adProviderNullMock = {name: 'NullMock'},
		adProviderDirectGptMobileMock = {
			name: 'GptMobileMock',
			canHandleSlot: function () { return true; }
		},
		adProviderRemnantGptMobileMock = {
			name: 'RemnantGptMobileMock',
			canHandleSlot: function () { return true; }
		},
		logMock = function () {},
		documentMock = {getElementById: function () { return true; }};

	function mockAdContext(showAds) {
		return {
			getContext: function () {
				return {
					opts: {
						showAds: showAds,
						pageType: 'all_ads'
					}
				};
			}
		};
	}

	it('getProvider returns GPT in the regular case', function () {
		var adConfigMobile = modules['ext.wikia.adEngine.adConfigMobile'](
			logMock,
			documentMock,
			mockAdContext(true),
			adProviderDirectGptMobileMock,
			adProviderRemnantGptMobileMock,
			adProviderNullMock
		);

		expect(adConfigMobile.getProvider(['foo'])).toBe(adProviderDirectGptMobileMock, 'GPT');
	});

	it('getProviders returns Null when wgShowAds set to false', function () {
		var adConfigMobile = modules['ext.wikia.adEngine.adConfigMobile'](
			logMock,
			documentMock,
			mockAdContext(false),
			adProviderDirectGptMobileMock,
			adProviderRemnantGptMobileMock,
			adProviderNullMock
		);

		// First check if NullProvider wins over Mobile GPT
		expect(adConfigMobile.getProvider(['foo'])).toBe(adProviderNullMock, 'Null over GPT');

		// Second check if NullProvider wins over Mobile Remnant
		expect(adConfigMobile.getProvider(['foo', null, 'RemnantGptMobile'])).
			toBe(adProviderNullMock, 'Null over RemnantGptMobile');
	});
});
