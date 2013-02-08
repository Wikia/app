/**
 * @test-require-asset extensions/wikia/AdEngine/js/AdConfig2.js
 */

describe('AdConfig2', function(){

	it('getProvider failsafe to Later', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
			, adProviderAdDriver2Mock = {name: 'AdDriver2Mock', canHandleSlot: function() {return false;}}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {}}
			, logMock = function() {}
			, windowMock = {}
			, documentMock = {}
			, adLogicShortPageMock = {isPageTooShortForSlot: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicShortPageMock, abTestMock

			// AdProviders
			, adProviderAdDriver2Mock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderLaterMock, 'adProviderLaterMock');
	});

	it('getProvider use AdDriver2 for high value slots', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
			, adProviderAdDriver2Mock = {name: 'AdDriver2Mock', canHandleSlot: function() {return true;}}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode: function() {return 'hi-value-country'}}
			, logMock = function() {}
			, windowMock = {wgHighValueCountries: {'hi-value-country': true, 'another-hi-value-country': true}}
			, documentMock = {}
			, adLogicShortPageMock = {isPageTooShortForSlot: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig
			, highValueSlot = 'TOP_LEADERBOARD'
			;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicShortPageMock, abTestMock

			// AdProviders
			, adProviderAdDriver2Mock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderLaterMock, 'adProviderLaterMock');
		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderAdDriver2Mock, 'adProviderAdDriver2Mock');
	});

	it('getProvider use Evolve for NZ (only if provider accepts)', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
			, adProviderEvolveMockHandling = {name: 'EvolveMock', canHandleSlot: function() {return true;}}
			, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMockAU = {getCountryCode:function() {return 'NZ';}}
			, logMock = function() {}
			, windowMock = {}
			, documentMock = {}
			, adLogicShortPageMock = {isPageTooShortForSlot: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMockAU, adLogicShortPageMock, abTestMock

			// AdProviders
			, adProviderAdDriver2Mock
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
			, adProviderAdDriver2Mock = {name: 'AdDriver2Mock', canHandleSlot: function() {return true;}}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {return 'PL';}}
			, logMock = function() {}
			, windowMock = {}
			, documentMock = {}
			, adLogicShortPageMock = {isPageTooShortForSlot: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicShortPageMock, abTestMock

			// AdProviders
			, adProviderAdDriver2Mock
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
			, adProviderAdDriver2Mock = {name: 'AdDriver2Mock', canHandleSlot: function() {return true;}}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {return 'NZ';}}
			, logMock = function() {}
			, windowMock = {}
			, documentMock = {}
			, adLogicShortPageMock = {isPageTooShortForSlot: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicShortPageMock, abTestMock

			// AdProviders
			, adProviderAdDriver2Mock
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
			, adProviderAdDriver2Mock = {name: 'AdDriver2Mock', canHandleSlot: function() {return false;}}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {}}
			, logMock = function() {}
			, windowMock = {wgContentLanguage: 'de'}
			, documentMock = {}
			, adLogicShortPageMock = {isPageTooShortForSlot: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicShortPageMock, abTestMock

			// AdProviders
			, adProviderAdDriver2Mock
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
			, adProviderAdDriver2Mock = {name: 'AdDriver2Mock', canHandleSlot: function() {return false;}}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {return 'NZ';}}
			, logMock = function() {}
			, windowMock = {wgContentLanguage: 'de'}
			, documentMock = {}
			, adLogicShortPageMock = {isPageTooShortForSlot: function() {return false;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		// First see if evolve is used for given configuration when GamePro refuses
		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicShortPageMock, abTestMock

			// AdProviders
			, adProviderAdDriver2Mock
			, adProviderEvolveMock
			, adProviderGameProMockRejecting
			, adProviderLaterMock
			, adProviderNullMock
		);
		expect(adConfig.getProvider(['TOP_LEADERBOARD'])).toBe(adProviderEvolveMock, 'adProviderEvolveMock TOP_LEADERBOARD');

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicShortPageMock, abTestMock

			// AdProviders
			, adProviderAdDriver2Mock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);
		expect(adConfig.getProvider(['TOP_LEADERBOARD'])).toBe(adProviderGameProMock, 'adProviderGameProMock TOP_LEADERBOARD');
	});

	it('getProvider calls adLogicShortPageMock.isPageTooShortForSlot with proper slot name', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return true;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
			, adProviderAdDriver2Mock = {name: 'AdDriver2Mock', canHandleSlot: function() {return false;}}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {}}
			, logMock = function() {}
			, windowMock = {}
			, documentMock = {}
			, adLogicShortPageCalledWithSlot
			, adLogicShortPageMock = {isPageTooShortForSlot: function(slot) {adLogicShortPageCalledWithSlot = slot;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicShortPageMock, abTestMock

			// AdProviders
			, adProviderAdDriver2Mock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);

		adConfig.getProvider(['foo']);
		expect(adLogicShortPageCalledWithSlot).toBe('foo');
	});

	it('getProvider returns Null on short page', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return true;}}
			, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
			, adProviderAdDriver2Mock = {name: 'AdDriver2Mock', canHandleSlot: function() {return false;}}
			, adProviderLaterMock = {name: 'LaterMock'}
			, geoMock = {getCountryCode:function() {}}
			, logMock = function() {}
			, windowMock = {}
			, documentMock = {}
			, adLogicShortPageMock = {isPageTooShortForSlot: function() {return true;}}
			, abTestMock = {inGroup: function() {return false;}}
			, adConfig;

		adConfig = AdConfig2(
			logMock, windowMock, documentMock, geoMock, adLogicShortPageMock, abTestMock

			// AdProviders
			, adProviderAdDriver2Mock
			, adProviderEvolveMock
			, adProviderGameProMock
			, adProviderLaterMock
			, adProviderNullMock
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderNullMock);
	});
});