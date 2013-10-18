describe('AdConfig2', function(){

	it('getProvider failsafe to Later', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
			, adProviderGptMock = {name:'GptMock', canHandleSlot: function() {return false;}}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {}}
			, logMock = function() {}
			, windowMock = {}
			, documentMock = {}
			, adLogicPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderGptMock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderLaterMock, 'adProviderLaterMock');
	});

	it('getProvider use GPT for high value slots', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
			, adProviderGptMock = {name:'GptMock', canHandleSlot: function() {return true;}}
			, adProviderLaterMock = {name: 'LaterMock', canHandleSlot: function() {return true;}}
			, geoMock = {getCountryCode: function() {return 'hi-value-country'}}
			, logMock = function() {}
			, windowMock = {wgHighValueCountries: {'hi-value-country': true, 'another-hi-value-country': true}}
			, documentMock = {}
			, adLogicPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig
			, highValueSlot = 'TOP_LEADERBOARD'
			;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderGptMock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderLaterMock, 'adProviderLaterMock');
		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderGptMock, 'adProviderGptMock');
	});

	it('getProvider use Evolve for NZ (only if provider accepts)', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
			, adProviderEvolveMockHandling = {name: 'EvolveMock', canHandleSlot: function() {return true;}}
			, adProviderGptMock = {name:'GptMock'}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMockAU = {getCountryCode:function() {return 'NZ';}}
			, logMock = function() {}
			, windowMock = {}
			, documentMock = {}
			, adLogicPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMockAU, adLogicPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderGptMock
			, adProviderEvolveMockHandling
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderEvolveMockHandling, 'adProviderEvolveMock NZ');
	});

	it('getProvider do not use Evolve for PL', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return true;}}
			, adProviderGptMock = {name:'GptMock'}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {return 'PL';}}
			, logMock = function() {}
			, windowMock = {}
			, documentMock = {}
			, adLogicPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderGptMock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);

		expect(adConfig.getProvider(['foo'])).not.toBe(adProviderEvolveMock, 'adProviderEvolveMock');
	});

	it('getProvider do not use Evolve for NZ when it cannot handle the slot', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
			, adProviderGptMock = {name:'GptMock'}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {return 'NZ';}}
			, logMock = function() {}
			, windowMock = {}
			, documentMock = {}
			, adLogicPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderGptMock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);

		expect(adConfig.getProvider(['foo'])).not.toBe(adProviderEvolveMock, 'adProviderEvolveMock');
	});

	it('getProvider use GamePro if provider says so', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return true;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
			, adProviderGptMock = {name:'GptMock'}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {}}
			, logMock = function() {}
			, windowMock = {wgContentLanguage: 'de'}
			, documentMock = {}
			, adLogicPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderGptMock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);

		expect(adConfig.getProvider(['TOP_LEADERBOARD'])).toBe(adProviderGameProMock, 'adProviderGameProMock TOP_LEADERBOARD');
		expect(adConfig.getProvider(['PREFOOTER_LEFT_BOXAD'])).toBe(adProviderLaterMock, 'adProviderLaterMock PREFOOTER_LEFT_BOXAD');
	});

	it('getProvider GamePro wins over Evolve', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMockRejecting = {name: 'GameProMock', canHandleSlot: function() {return false;}}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return true;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return true;}}
			, adProviderGptMock = {name:'GptMock'}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {return 'NZ';}}
			, logMock = function() {}
			, windowMock = {wgContentLanguage: 'de'}
			, documentMock = {}
			, adLogicPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		// First see if evolve is used for given configuration when GamePro refuses
		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderGptMock
			, adProviderEvolveMock
			, adProviderGameProMockRejecting
			, adProviderLaterMock
			, adProviderNullMock
		);
		expect(adConfig.getProvider(['TOP_LEADERBOARD'])).toBe(adProviderEvolveMock, 'adProviderEvolveMock TOP_LEADERBOARD');

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderGptMock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);
		expect(adConfig.getProvider(['TOP_LEADERBOARD'])).toBe(adProviderGameProMock, 'adProviderGameProMock TOP_LEADERBOARD');
	});

	it('getProvider calls adLogicPageDimensionsMock.isApplicable with proper slot name', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return true;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
			, adProviderGptMock = {name:'GptMock'}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {}}
			, logMock = function() {}
			, windowMock = {}
			, documentMock = {}
			, adLogicPageDimensionsCalledWithSlot
			, adLogicPageDimensionsMock = {isApplicable: function(slot) {adLogicPageDimensionsCalledWithSlot = slot;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderGptMock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);

		adConfig.getProvider(['foo']);
		expect(adLogicPageDimensionsCalledWithSlot).toEqual(['foo']);
	});

	it('getProvider returns WindowSizeProviderProxy if AdLogicPageDimensions say so', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderProxyMock = {name: 'WindowSizeProviderProxyMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return true;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
			, adProviderGptMock = {name:'GptMock'}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {}}
			, logMock = function() {}
			, windowMock = {}
			, documentMock = {}
			, adLogicPageDimensionsMock = {isApplicable: function() {return true;}, getProxy: function() {return adProviderProxyMock;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderGptMock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderProxyMock);
	});
});
