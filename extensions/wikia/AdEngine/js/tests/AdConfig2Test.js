/*
@test-framework QUnit
 @test-require-asset resources/wikia/modules/querystring.js
 @test-require-asset resources/wikia/modules/cookies.js
 @test-require-asset resources/wikia/modules/log.js
 @test-require-asset extensions/wikia/AdEngine/js/AdConfig2.js
*/
module('AdConfig2');

test('getProvider failsafe to AdDriver', function() {
	// setup
	var adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderAdDriverMock = {name: 'AdDriverMock'}
		, adProviderLiftium2Mock = {name: 'Liftium2Mock'}
		, adConfig;

	adConfig = AdConfig2(
		Wikia.log, Wikia, window,
		// AdProviders
		adProviderGameProMock,
		adProviderEvolveMock,
		adProviderEvolveRSMock,
		adProviderAdDriver2Mock,
		adProviderAdDriverMock,
		adProviderLiftium2Mock
	);

	equal(adConfig.getProvider(['foo']), adProviderAdDriverMock, 'adProviderAdDriverMock');
});

test('getProvider use Evolve if provider says so', function() {
	// setup
	var adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return true;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderAdDriverMock = {name: 'AdDriverMock'}
		, adProviderLiftium2Mock = {name: 'Liftium2Mock'}
		, adConfig;

	adConfig = AdConfig2(
		Wikia.log, Wikia, window,
		// AdProviders
		adProviderGameProMock,
		adProviderEvolveMock,
		adProviderEvolveRSMock,
		adProviderAdDriver2Mock,
		adProviderAdDriverMock,
		adProviderLiftium2Mock
	);

	equal(adConfig.getProvider(['foo']), adProviderEvolveMock, 'adProviderEvolveMock');
});

test('getProvider use GamePro if provider says so', function() {
	// setup
	var adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return true;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderAdDriverMock = {name: 'AdDriverMock'}
		, adProviderLiftium2Mock = {name: 'Liftium2Mock'}
		, adConfig;

	adConfig = AdConfig2(
		Wikia.log, Wikia, window,
		// AdProviders
		adProviderGameProMock,
		adProviderEvolveMock,
		adProviderEvolveRSMock,
		adProviderAdDriver2Mock,
		adProviderAdDriverMock,
		adProviderLiftium2Mock
	);

	equal(adConfig.getProvider(['foo']), adProviderGameProMock, 'adProviderGameProMock');
});

test('getProvider GamePro wins over Evolve', function() {
	// setup
	var adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return true;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return true;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return false;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderAdDriverMock = {name: 'AdDriverMock'}
		, adProviderLiftium2Mock = {name: 'Liftium2Mock'}
		, adConfig;

	adConfig = AdConfig2(
		Wikia.log, Wikia, window,
		// AdProviders
		adProviderGameProMock,
		adProviderEvolveMock,
		adProviderEvolveRSMock,
		adProviderAdDriver2Mock,
		adProviderAdDriverMock,
		adProviderLiftium2Mock
	);

	equal(adConfig.getProvider(['foo']), adProviderGameProMock, 'adProviderGameProMock');
});

test('getProvider use EvolveRS if provider says so', function() {
		var adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function() {return false;}}
		, adProviderEvolveRSMock = {name: 'EvolveRSMock', canHandleSlot: function() {return true;}}
		, adProviderAdDriver2Mock = {name: 'AdDriver2Mock'}
		, adProviderAdDriverMock = {name: 'AdDriverMock'}
		, adProviderLiftium2Mock = {name: 'Liftium2Mock'}
		, adConfig;

	adConfig = AdConfig2(
		Wikia.log, Wikia, window,
		// AdProviders
		adProviderGameProMock,
		adProviderEvolveMock,
		adProviderEvolveRSMock,
		adProviderAdDriver2Mock,
		adProviderAdDriverMock,
		adProviderLiftium2Mock
	);

	equal(adConfig.getProvider(['foo']), adProviderEvolveRSMock, 'adProviderEvolveRSMock');
});
