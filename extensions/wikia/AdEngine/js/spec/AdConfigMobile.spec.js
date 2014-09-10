describe('AdConfigMobile', function(){


	it('wgShowAds set to false blocks all providers on mobile', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderDirectGptMobileMock = {name:'GptMobileMock', canHandleSlot: function() {return true}}
			, adProviderRemnantGptMobileMock = {name: 'RemnantGptMobileMock', canHandleSlot: function() {return true}}
			, adProviderEbayMock = {name: 'EbayMock', canHandleSlot: function() {return true}}
			, logMock = function() {}
			, windowMock = {wgShowAds: false}
			, documentMock = {getElementById: function(){return true}}
			, adConfigMobile;

		adConfigMobile = modules['ext.wikia.adEngine.adConfigMobile'] (
			logMock,
			windowMock,
			documentMock,
			adProviderDirectGptMobileMock,
			adProviderRemnantGptMobileMock,
			adProviderNullMock,
			adProviderEbayMock
		);

		// First check if NullProvider wins over Mobile GPT
		expect(adConfigMobile.getProvider(['foo'])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');

		// Second check if NullProvider wins over Ebay
		windowMock.wgAdDriverUseEbay = true;
		expect(adConfigMobile.getProvider(['MOBILE_PREFOOTER'])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');

		// Third check if NullProvider wins over Mobile Remnant
		expect(adConfigMobile.getProvider(['foo', null, 'RemnantGptMobile'])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');
	});
});
