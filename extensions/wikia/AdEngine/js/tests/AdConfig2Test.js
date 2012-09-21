/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdConfig2.js
 */

module('AdConfig2');

test('getProvider failsafe to Later', function() {
	var adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderAdDriverMock = {name: 'AdDriverMock'}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMock = {getCountryCode:function() {}}
		, logMock = function() {}
		, windowMock = {}
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, geoMock,
		// AdProviders
		adProviderGameProMock,
		adProviderEvolveMock,
		adProviderEvolveRSMock,
		adProviderAdDriver2Mock,
		adProviderAdDriverMock,
		adProviderLaterMock
	);

	equal(adConfig.getProvider(['foo']), adProviderLaterMock, 'adProviderLaterMock');
});

test('getProvider use AdDriver2 for high value countries', function() {
	var adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderAdDriverMock = {name: 'AdDriverMock'}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMock = {getCountryCode:function() {return 'hi-value-country'}}
		, logMock = function() {}
		, windowMock = {wgHighValueCountries: {'hi-value-country': true, 'another-hi-value-country': true}}
		, adConfig
		, highValueSlot = 'TOP_LEADERBOARD';

	adConfig = AdConfig2(
		logMock, windowMock, geoMock,
		// AdProviders
		adProviderGameProMock,
		adProviderEvolveMock,
		adProviderEvolveRSMock,
		adProviderAdDriver2Mock,
		adProviderAdDriverMock,
		adProviderLaterMock
	);

	equal(adConfig.getProvider(['foo']), adProviderLaterMock, 'adProviderLaterMock');
	equal(adConfig.getProvider([highValueSlot]), adProviderAdDriver2Mock, 'adProviderAdDriver2Mock');
});

test('getProvider use Evolve(RS) for AU (only if provider accepts)', function() {
	var adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMockHandling = {name: 'EvolveMock', canHandleSlot: function() {return true;}}
		, adProviderEvolveRSMockHandling = {name: 'EvolveRSMock', canHandleSlot: function() {return true;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderAdDriverMock = {name: 'AdDriverMock'}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMockAU = {getCountryCode:function() {return 'AU';}}
		, logMock = function() {}
		, windowMock = {}
		, adConfig, adConfigRS;

	adConfig = AdConfig2(
		logMock, windowMock, geoMockAU,
		// AdProviders
		adProviderGameProMock,
		adProviderEvolveMockHandling,
		adProviderEvolveRSMock,
		adProviderAdDriver2Mock,
		adProviderAdDriverMock,
		adProviderLaterMock
	);

	adConfigRS = AdConfig2(
		logMock, windowMock, geoMockAU,
		// AdProviders
		adProviderGameProMock,
		adProviderEvolveMock,
		adProviderEvolveRSMockHandling,
		adProviderAdDriver2Mock,
		adProviderAdDriverMock,
		adProviderLaterMock
	);

	equal(adConfig.getProvider(['foo']), adProviderEvolveMockHandling, 'adProviderEvolveMock AU');
	equal(adConfigRS.getProvider(['foo']), adProviderEvolveRSMockHandling, 'adProviderEvolveRSMock AU');
});

test('getProvider do not use Evolve(RS) for PL', function() {
	var adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return true;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderAdDriverMock = {name: 'AdDriverMock'}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMock = {getCountryCode:function() {return 'PL';}}
		, logMock = function() {}
		, windowMock = {}
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, geoMock,
		// AdProviders
		adProviderGameProMock,
		adProviderEvolveMock,
		adProviderEvolveRSMock,
		adProviderAdDriver2Mock,
		adProviderAdDriverMock,
		adProviderLaterMock
	);

	notEqual(adConfig.getProvider(['foo']), adProviderEvolveMock, 'adProviderEvolveMock');
});

test('getProvider do not use Evolve(RS) for AU when it cannot handle the slot', function() {
	var adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderAdDriverMock = {name: 'AdDriverMock'}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMock = {getCountryCode:function() {return 'AU';}}
		, logMock = function() {}
		, windowMock = {}
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, geoMock,
		// AdProviders
		adProviderGameProMock,
		adProviderEvolveMock,
		adProviderEvolveRSMock,
		adProviderAdDriver2Mock,
		adProviderAdDriverMock,
		adProviderLaterMock
	);

	notEqual(adConfig.getProvider(['foo']), adProviderEvolveMock, 'adProviderEvolveMock');
});

test('getProvider use GamePro if provider says so', function() {
	var adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return true;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderAdDriverMock = {name: 'AdDriverMock'}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMock = {getCountryCode:function() {}}
		, logMock = function() {}
		, windowMock = {}
		, adConfig;

	adConfig = AdConfig2(
		logMock, windowMock, geoMock,
		// AdProviders
		adProviderGameProMock,
		adProviderEvolveMock,
		adProviderEvolveRSMock,
		adProviderAdDriver2Mock,
		adProviderAdDriverMock,
		adProviderLaterMock
	);

	equal(adConfig.getProvider(['foo']), adProviderGameProMock, 'adProviderGameProMock');
});

test('getProvider GamePro wins over Evolve', function() {
	var adProviderGameProMockRejecting = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return true;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return true;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderAdDriverMock = {name: 'AdDriverMock'}
		, adProviderLaterMock = {name: 'LaterMock'}
		, geoMock = {getCountryCode:function() {return 'AU';}}
		, logMock = function() {}
		, windowMock = {}
		, adConfig;

	// First see if evolve is used for given configuration when GamePro refuses
	adConfig = AdConfig2(
		logMock, windowMock, geoMock,
		// AdProviders
		adProviderGameProMockRejecting,
		adProviderEvolveMock,
		adProviderEvolveRSMock,
		adProviderAdDriver2Mock,
		adProviderAdDriverMock,
		adProviderLaterMock
	);
	equal(adConfig.getProvider(['foo']), adProviderEvolveMock, 'adProviderEvolveMock');

	adConfig = AdConfig2(
		logMock, windowMock, geoMock,
		// AdProviders
		adProviderGameProMock,
		adProviderEvolveMock,
		adProviderEvolveRSMock,
		adProviderAdDriver2Mock,
		adProviderAdDriverMock,
		adProviderLaterMock
	);
	equal(adConfig.getProvider(['foo']), adProviderGameProMock, 'adProviderGameProMock');
});
