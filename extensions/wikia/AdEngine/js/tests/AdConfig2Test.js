/*
@test-framework QUnit
 @test-require-asset resources/wikia/modules/querystring.js
 @test-require-asset resources/wikia/modules/cookies.js
 @test-require-asset resources/wikia/modules/log.js
 @test-require-asset extensions/wikia/AdEngine/AdConfig2.js
*/
module('AdConfig2');

test('getProvider failsafe', function() {
	// setup
	AdConfig2.getCountry = function() {
		return 'error';
	};

	equal(AdConfig2.getProvider(['foo']), 'AdDriver2', 'AdDriver2');
});

// TODO may be refactored to AdProviderEvolve
test('getProvider evolve AU', function() {
	// setup
	AdConfig2.getCountry = function() {
		return 'AU';
	};

	equal(AdConfig2.getProvider(['TOP_LEADERBOARD']), 'Evolve', 'TOP_LEADERBOARD');
	//equal(AdConfig2.getProvider(['TOP_RIGHT_BOXAD']), 'Evolve', 'TOP_RIGHT_BOXAD');
	equal(AdConfig2.getProvider(['LEFT_SKYSCRAPER_2']), 'Evolve', 'LEFT_SKYSCRAPER_2');

	notEqual(AdConfig2.getProvider(['INCONTENT_BOXAD_1']), 'Evolve', 'INCONTENT_BOXAD_1');
	notEqual(AdConfig2.getProvider(['PREFOOTER_LEFT_BOXAD']), 'Evolve', 'PREFOOTER_LEFT_BOXAD');
	notEqual(AdConfig2.getProvider(['PREFOOTER_RIGHT_BOXAD']), 'Evolve', 'PREFOOTER_RIGHT_BOXAD');
});

// TODO may be refactored to AdProviderEvolve
test('getProvider evolve not AU', function() {
	// setup
	AdConfig2.getCountry = function() {
		return 'not AU';
	};

	notEqual(AdConfig2.getProvider(['TOP_LEADERBOARD']), 'Evolve', 'TOP_LEADERBOARD');
	notEqual(AdConfig2.getProvider(['TOP_RIGHT_BOXAD']), 'Evolve', 'TOP_RIGHT_BOXAD');
	notEqual(AdConfig2.getProvider(['LEFT_SKYSCRAPER_2']), 'Evolve', 'LEFT_SKYSCRAPER_2');
});
