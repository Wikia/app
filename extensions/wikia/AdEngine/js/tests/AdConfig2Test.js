/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdConfig2.js
 */

module('AdConfig2');

test('getProvider failsafe to Later', function() {
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
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock, adLogicShortPageMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);

	equal(adConfig.getProvider(['foo']), adProviderLaterMock, 'adProviderLaterMock');
});

test('getProvider use AdDriver2 for high value slots', function() {
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
		, adConfig
		, highValueSlot = 'TOP_LEADERBOARD'
	;

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock, adLogicShortPageMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);

	equal(adConfig.getProvider(['foo']), adProviderLaterMock, 'adProviderLaterMock');
	equal(adConfig.getProvider([highValueSlot]), adProviderAdDriver2Mock, 'adProviderAdDriver2Mock');
});

test('getProvider use Evolve for NZ (only if provider accepts)', function() {
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
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMockAU, adLogicShortPageMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMockHandling
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);

	equal(adConfig.getProvider(['foo']), adProviderEvolveMockHandling, 'adProviderEvolveMock NZ');
});

test('getProvider do not use Evolve for PL', function() {
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
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock, adLogicShortPageMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);

	notEqual(adConfig.getProvider(['foo']), adProviderEvolveMock, 'adProviderEvolveMock');
});

test('getProvider do not use Evolve for NZ when it cannot handle the slot', function() {
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
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock, adLogicShortPageMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);

	notEqual(adConfig.getProvider(['foo']), adProviderEvolveMock, 'adProviderEvolveMock');
});

test('getProvider use GamePro if provider says so', function() {
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
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock, adLogicShortPageMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);

	equal(adConfig.getProvider(['TOP_LEADERBOARD']), adProviderGameProMock, 'adProviderGameProMock TOP_LEADERBOARD');
	equal(adConfig.getProvider(['PREFOOTER_LEFT_BOXAD']), adProviderLaterMock, 'adProviderLaterMock PREFOOTER_LEFT_BOXAD');
});

test('getProvider GamePro wins over Evolve', function() {
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
		, adConfig;

	// First see if evolve is used for given configuration when GamePro refuses
	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock, adLogicShortPageMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderGameProMockRejecting
		, adProviderLaterMock
		, adProviderNullMock
	);
	equal(adConfig.getProvider(['TOP_LEADERBOARD']), adProviderEvolveMock, 'adProviderEvolveMock TOP_LEADERBOARD');

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock, adLogicShortPageMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);
	equal(adConfig.getProvider(['TOP_LEADERBOARD']), adProviderGameProMock, 'adProviderGameProMock TOP_LEADERBOARD');
});

test('getProvider calls adLogicShortPageMock.isPageTooShortForSlot with proper slot name', function() {
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
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock, adLogicShortPageMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);

	adConfig.getProvider(['foo']);
	equal(adLogicShortPageCalledWithSlot, 'foo');
});

test('getProvider returns Null if for some slots for short pages', function() {
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
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock, adLogicShortPageMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);

	equal(adConfig.getProvider(['foo']), adProviderNullMock);
});
