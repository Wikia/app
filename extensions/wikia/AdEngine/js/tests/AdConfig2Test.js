/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdConfig2.js
 */

module('AdConfig2');

test('getProvider failsafe to Later', function() {
	var adProviderNullMock = {name: 'NullMock'}
		, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMock = {getCountryCode:function() {}}
		, logMock = function() {}
		, windowMock = {}
		, documentMock = {documentElement: {offsetHeight: 99999}}
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderEvolveRSMock
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);

	equal(adConfig.getProvider(['foo']), adProviderLaterMock, 'adProviderLaterMock');
});

test('getProvider use AdDriver2 for high value countries', function() {
	var adProviderNullMock = {name: 'NullMock'}
		, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock', canHandleSlot: function() {return true;}}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMock = {getCountryCode: function() {return 'hi-value-country'}}
		, logMock = function() {}
		, windowMock = {wgHighValueCountries: {'hi-value-country': true, 'another-hi-value-country': true}}
		, documentMock = {documentElement: {offsetHeight: 99999}}
		, adConfig
		, highValueSlot = 'TOP_LEADERBOARD';

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderEvolveRSMock
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);

	equal(adConfig.getProvider(['foo']), adProviderLaterMock, 'adProviderLaterMock');
	equal(adConfig.getProvider([highValueSlot]), adProviderAdDriver2Mock, 'adProviderAdDriver2Mock'); // TODO change back after the rollout
});

test('getProvider use Evolve(RS) for NZ (only if provider accepts)', function() {
	var adProviderNullMock = {name: 'NullMock'}
		, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMockHandling = {name: 'EvolveMock', canHandleSlot: function() {return true;}}
		, adProviderEvolveRSMockHandling = {name: 'EvolveRSMock', canHandleSlot: function() {return true;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMockAU = {getCountryCode:function() {return 'NZ';}}
		, logMock = function() {}
		, windowMock = {}
		, documentMock = {documentElement: {offsetHeight: 99999}}
		, adConfig, adConfigRS;

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMockAU

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMockHandling
		, adProviderEvolveRSMock
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);

	adConfigRS = AdConfig2(
		logMock, windowMock, documentMock, geoMockAU

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderEvolveRSMockHandling
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);

	equal(adConfig.getProvider(['foo']), adProviderEvolveMockHandling, 'adProviderEvolveMock NZ');
	equal(adConfigRS.getProvider(['foo']), adProviderEvolveRSMockHandling, 'adProviderEvolveRSMock NZ');
});

test('getProvider do not use Evolve(RS) for PL', function() {
	var adProviderNullMock = {name: 'NullMock'}
		, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return true;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMock = {getCountryCode:function() {return 'PL';}}
		, logMock = function() {}
		, windowMock = {}
		, documentMock = {documentElement: {offsetHeight: 99999}}
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderEvolveRSMock
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);

	notEqual(adConfig.getProvider(['foo']), adProviderEvolveMock, 'adProviderEvolveMock');
});

test('getProvider do not use Evolve(RS) for NZ when it cannot handle the slot', function() {
	var adProviderNullMock = {name: 'NullMock'}
		, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMock = {getCountryCode:function() {return 'NZ';}}
		, logMock = function() {}
		, windowMock = {}
		, documentMock = {documentElement: {offsetHeight: 99999}}
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderEvolveRSMock
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
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMock = {getCountryCode:function() {}}
		, logMock = function() {}
		, windowMock = {wgContentLanguage: 'de'}
		, documentMock = {documentElement: {offsetHeight: 99999}}
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderEvolveRSMock
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
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMock = {getCountryCode:function() {return 'NZ';}}
		, logMock = function() {}
		, windowMock = {wgContentLanguage: 'de'}
		, documentMock = {documentElement: {offsetHeight: 99999}}
		, adConfig;

	// First see if evolve is used for given configuration when GamePro refuses
	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderEvolveRSMock
		, adProviderGameProMockRejecting
		, adProviderLaterMock
		, adProviderNullMock
	);
	equal(adConfig.getProvider(['TOP_LEADERBOARD']), adProviderEvolveMock, 'adProviderEvolveMock TOP_LEADERBOARD');

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderEvolveRSMock
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);
	equal(adConfig.getProvider(['TOP_LEADERBOARD']), adProviderGameProMock, 'adProviderGameProMock TOP_LEADERBOARD');
});

test('getProvider returns Null for some slots for short pages', function() {
	var adProviderNullMock = {name: 'NullMock'}
		, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return true;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMock = {getCountryCode:function() {}}
		, logMock = function() {}
		, windowMock = {}
		, documentMock = {documentElement: {}}
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, documentMock, geoMock

		// AdProviders
		, adProviderAdDriver2Mock
		, adProviderEvolveMock
		, adProviderEvolveRSMock
		, adProviderGameProMock
		, adProviderLaterMock
		, adProviderNullMock
	);

	documentMock.documentElement.offsetHeight = 1000;
	notEqual(adConfig.getProvider(['foo']), adProviderNullMock, 'height=1000 slot=foo -> ADS');
	equal(adConfig.getProvider(['LEFT_SKYSCRAPER_2']), adProviderNullMock, 'height=1000 slot=LEFT_SKYSCRAPER_2 -> NO ADS');
	equal(adConfig.getProvider(['LEFT_SKYSCRAPER_3']), adProviderNullMock, 'height=1000 slot=LEFT_SKYSCRAPER_3 -> NO ADS');
	equal(adConfig.getProvider(['PREFOOTER_LEFT_BOXAD']), adProviderNullMock, 'height=1000 slot=PREFOOTER_LEFT_BOXAD -> NO ADS');
	equal(adConfig.getProvider(['PREFOOTER_RIGHT_BOXAD']), adProviderNullMock, 'height=1000 slot=PREFOOTER_RIGHT_BOXAD -> NO ADS');

	documentMock.documentElement.offsetHeight = 3000;
	notEqual(adConfig.getProvider(['foo']), adProviderNullMock, 'height=3000 slot=foo -> ADS');
	notEqual(adConfig.getProvider(['LEFT_SKYSCRAPER_2']), adProviderNullMock, 'height=3000 slot=LEFT_SKYSCRAPER_2 -> ADS');
	equal(adConfig.getProvider(['LEFT_SKYSCRAPER_3']), adProviderNullMock, 'height=3000 slot=LEFT_SKYSCRAPER_3 -> NO ADS');
	notEqual(adConfig.getProvider(['PREFOOTER_LEFT_BOXAD']), adProviderNullMock, 'height=3000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
	notEqual(adConfig.getProvider(['PREFOOTER_RIGHT_BOXAD']), adProviderNullMock, 'height=3000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

	documentMock.documentElement.offsetHeight = 5000;
	notEqual(adConfig.getProvider(['foo']), adProviderNullMock, 'height=5000 slot=foo -> ADS');
	notEqual(adConfig.getProvider(['LEFT_SKYSCRAPER_2']), adProviderNullMock, 'height=5000 slot=LEFT_SKYSCRAPER_2 -> ADS');
	notEqual(adConfig.getProvider(['LEFT_SKYSCRAPER_3']), adProviderNullMock, 'height=5000 slot=LEFT_SKYSCRAPER_3 -> ADS');
	notEqual(adConfig.getProvider(['PREFOOTER_LEFT_BOXAD']), adProviderNullMock, 'height=5000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
	notEqual(adConfig.getProvider(['PREFOOTER_RIGHT_BOXAD']), adProviderNullMock, 'height=5000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

});
