describe('AdConfig2', function(){

	it('getProvider failsafe to Later', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
			, adProviderDirectGptMock = {name:'GptMock', canHandleSlot: function() {return false;}}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {}}
			, logMock = function() {}
			, windowMock = {wgShowAds: true}
			, documentMock = {}
			, adDecoratorPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adDecoratorPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderDirectGptMock
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
			, adProviderDirectGptMock = {name:'GptMock', canHandleSlot: function() {return true;}}
			, adProviderLaterMock = {name: 'LaterMock', canHandleSlot: function() {return true;}}
			, geoMock = {getCountryCode: function() {return 'hi-value-country'}}
			, logMock = function() {}
			, windowMock = {wgHighValueCountries: {'hi-value-country': true, 'another-hi-value-country': true}, wgShowAds: true}
			, documentMock = {}
			, adDecoratorPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig
			, highValueSlot = 'TOP_LEADERBOARD'
			;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adDecoratorPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderDirectGptMock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderLaterMock, 'adProviderLaterMock');
		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderDirectGptMock, 'adProviderDirectGptMock');
	});

	it('getProvider use Evolve for NZ (only if provider accepts)', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
			, adProviderEvolveMockHandling = {name: 'EvolveMock', canHandleSlot: function() {return true;}}
			, adProviderDirectGptMock = {name:'GptMock'}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMockAU = {getCountryCode:function() {return 'NZ';}}
			, logMock = function() {}
			, windowMock = {wgShowAds: true}
			, documentMock = {}
			, adDecoratorPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMockAU, adDecoratorPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderDirectGptMock
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
			, adProviderDirectGptMock = {name:'GptMock'}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {return 'PL';}}
			, logMock = function() {}
			, windowMock = {wgShowAds: true}
			, documentMock = {}
			, adDecoratorPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adDecoratorPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderDirectGptMock
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
			, adProviderDirectGptMock = {name:'GptMock'}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {return 'NZ';}}
			, logMock = function() {}
			, windowMock = {wgShowAds: true}
			, documentMock = {}
			, adDecoratorPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adDecoratorPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderDirectGptMock
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
			, adProviderDirectGptMock = {name:'GptMock'}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {}}
			, logMock = function() {}
			, windowMock = {wgContentLanguage: 'de', wgShowAds: true}
			, documentMock = {}
			, adDecoratorPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adDecoratorPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderDirectGptMock
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
			, adProviderDirectGptMock = {name:'GptMock'}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {return 'NZ';}}
			, logMock = function() {}
			, windowMock = {wgContentLanguage: 'de', wgShowAds: true}
			, documentMock = {}
			, adDecoratorPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		// First see if evolve is used for given configuration when GamePro refuses
		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adDecoratorPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderDirectGptMock
			, adProviderEvolveMock
			, adProviderGameProMockRejecting
			, adProviderLaterMock
			, adProviderNullMock
		);
		expect(adConfig.getProvider(['TOP_LEADERBOARD'])).toBe(adProviderEvolveMock, 'adProviderEvolveMock TOP_LEADERBOARD');

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adDecoratorPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderDirectGptMock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);
		expect(adConfig.getProvider(['TOP_LEADERBOARD'])).toBe(adProviderGameProMock, 'adProviderGameProMock TOP_LEADERBOARD');
	});

	it('getProvider Null wins over all', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return true;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return true;}}
			, adProviderDirectGptMock = {name:'GptMock', canHandleSlot: function() {return true}}
			, adProviderLaterMock = {name: 'LaterMock', canHandleSlot: function() {return true}}
			, geoMock = {getCountryCode: function() {return 'hi-value-country'}}
			, logMock = function() {}
			, windowMock = {wgHighValueCountries: {'hi-value-country': true}, wgShowAds: false}
			, documentMock = {}
			, adDecoratorPageDimensionsMock = {isApplicable: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adDecoratorPageDimensionsMock, abTestMock

			// AdProviders
			, adProviderDirectGptMock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);

		// First check if NullProvider wins over GPT
		expect(adConfig.getProvider(['TOP_LEADERBOARD'])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');

		// Second check if NullProvider wins over Later
		geoMock.getCountryCode = function() {};
		expect(adConfig.getProvider(['foo'])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');

		// Third check if NullProvider wins over Evolve
		geoMock.getCountryCode = function() {return 'NZ'};
		expect(adConfig.getProvider(['TOP_LEADERBOARD'])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');

		// Fourth check if NullProvider wins over GamePro
		windowMock.contentLanguage = 'de';
		expect(adConfig.getProvider(['TOP_LEADERBOARD'])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');

	})
});
