/*
@test-framework QUnit
 @test-require-asset resources/wikia/modules/querystring.js
 @test-require-asset resources/wikia/modules/cookies.js
 @test-require-asset resources/wikia/modules/log.js
 @test-require-asset extensions/wikia/AdEngine/js/AdConfig2.js
*/
module('AdConfig2');

test('getProvider failsafe', function() {
	// setup
	var AdProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, AdProviderEvolveMock = {name: 'EvolveMock'}
		, AdProviderEvolveRSMock = {name: 'EvolveRSMock'}
		, AdProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, AdProviderAdDriverMock = {name: 'AdDriverMock'}
		, AdProviderLiftium2Mock = {name: 'Liftium2Mock'}
		, adConfig;

	window.wgContentLanguage = 'not de';
	window.testUseCountry = 'error';

	adConfig = AdConfig2(
		Wikia.log, Wikia, window,
		// AdProviders
		AdProviderGameProMock,
		AdProviderEvolveMock,
		AdProviderEvolveRSMock,
		AdProviderAdDriver2Mock,
		AdProviderAdDriverMock,
		AdProviderLiftium2Mock
	);

	equal(adConfig.getProvider(['foo']).name, 'AdDriverMock', 'AdDriverMock');
});

// TODO may be refactored to AdProviderEvolve
test('getProvider evolve AU', function() {
	// setup
	var AdProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, AdProviderEvolveMock = {name: 'EvolveMock'}
		, AdProviderEvolveRSMock = {name: 'EvolveRSMock'}
		, AdProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, AdProviderAdDriverMock = {name: 'AdDriverMock'}
		, AdProviderLiftium2Mock = {name: 'Liftium2Mock'}
		, adConfig;

	window.testUseCountry = 'AU';

	adConfig = AdConfig2(
		Wikia.log, Wikia, window,
		// AdProviders
		AdProviderGameProMock,
		AdProviderEvolveMock,
		AdProviderEvolveRSMock,
		AdProviderAdDriver2Mock,
		AdProviderAdDriverMock,
		AdProviderLiftium2Mock
	);

	equal(adConfig.getProvider(['TOP_LEADERBOARD']).name, 'EvolveMock', 'TOP_LEADERBOARD');
	equal(adConfig.getProvider(['TOP_RIGHT_BOXAD']).name, 'EvolveMock', 'TOP_RIGHT_BOXAD');
	equal(adConfig.getProvider(['LEFT_SKYSCRAPER_2']).name, 'EvolveMock', 'LEFT_SKYSCRAPER_2');

	notEqual(adConfig.getProvider(['INCONTENT_BOXAD_1']).name, 'EvolveMock', 'INCONTENT_BOXAD_1');
	notEqual(adConfig.getProvider(['PREFOOTER_LEFT_BOXAD']).name, 'EvolveMock', 'PREFOOTER_LEFT_BOXAD');
	notEqual(adConfig.getProvider(['PREFOOTER_RIGHT_BOXAD']).name, 'EvolveMock', 'PREFOOTER_RIGHT_BOXAD');
});

// TODO may be refactored to AdProviderEvolve
test('getProvider evolve not AU', function() {
	// setup
	var AdProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, AdProviderEvolveMock = {name: 'EvolveMock'}
		, AdProviderEvolveRSMock = {name: 'EvolveRSMock'}
		, AdProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, AdProviderAdDriverMock = {name: 'AdDriverMock'}
		, AdProviderLiftium2Mock = {name: 'Liftium2Mock'}
		, adConfig;

	window.testUseCountry = 'not AU';

	adConfig = AdConfig2(
		Wikia.log, Wikia, window,
		// AdProviders
		AdProviderGameProMock,
		AdProviderEvolveMock,
		AdProviderEvolveRSMock,
		AdProviderAdDriver2Mock,
		AdProviderAdDriverMock,
		AdProviderLiftium2Mock
	);

	notEqual(adConfig.getProvider(['TOP_LEADERBOARD']).name, 'EvolveMock', 'TOP_LEADERBOARD');
	notEqual(adConfig.getProvider(['TOP_RIGHT_BOXAD']).name, 'EvolveMock', 'TOP_RIGHT_BOXAD');
	notEqual(adConfig.getProvider(['LEFT_SKYSCRAPER_2']).name, 'EvolveMock', 'LEFT_SKYSCRAPER_2');
});
