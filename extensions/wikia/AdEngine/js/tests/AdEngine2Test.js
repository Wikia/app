/*
@test-framework QUnit
 @test-require-asset resources/wikia/modules/querystring.js
 @test-require-asset resources/wikia/modules/cookies.js
 @test-require-asset resources/wikia/modules/log.js
 @test-require-asset extensions/wikia/AdEngine/AdEngine2.js
*/
module('AdEngine2');

test('moveQueue', function() {
	// setup
	var slots_done = [];
	AdEngine2.fillInSlot = function(slot) {
		slots_done.push(slot);
	};

	window.adslots2 = [];
	window.adslots2.push(['foo']);
	window.adslots2.push(['bar']);
	AdEngine2.init();

	equal(slots_done.length, 2, 'pre move');

	window.adslots2.push(['baz']);

	equal(slots_done.length, 3, 'post move');
});

test('getProvider failsafe', function() {
	// setup
	AdEngine2.getCountry = function() {
		return 'error';
	};

	equal(AdEngine2.getProvider(['foo']), 'AdDriver2', 'AdDriver2');
});

// TODO may be refactored to AdProviderEvolve
test('getProvider evolve AU', function() {
	// setup
	AdEngine2.getCountry = function() {
		return 'AU';
	};

	equal(AdEngine2.getProvider(['TOP_LEADERBOARD']), 'Evolve', 'TOP_LEADERBOARD');
	//equal(AdEngine2.getProvider(['TOP_RIGHT_BOXAD']), 'Evolve', 'TOP_RIGHT_BOXAD');
	equal(AdEngine2.getProvider(['LEFT_SKYSCRAPER_2']), 'Evolve', 'LEFT_SKYSCRAPER_2');

	notEqual(AdEngine2.getProvider(['INCONTENT_BOXAD_1']), 'Evolve', 'INCONTENT_BOXAD_1');
	notEqual(AdEngine2.getProvider(['PREFOOTER_LEFT_BOXAD']), 'Evolve', 'PREFOOTER_LEFT_BOXAD');
	notEqual(AdEngine2.getProvider(['PREFOOTER_RIGHT_BOXAD']), 'Evolve', 'PREFOOTER_RIGHT_BOXAD');
});

// TODO may be refactored to AdProviderEvolve
test('getProvider evolve not AU', function() {
	// setup
	AdEngine2.getCountry = function() {
		return 'not AU';
	};

	notEqual(AdEngine2.getProvider(['TOP_LEADERBOARD']), 'Evolve', 'TOP_LEADERBOARD');
	notEqual(AdEngine2.getProvider(['TOP_RIGHT_BOXAD']), 'Evolve', 'TOP_RIGHT_BOXAD');
	notEqual(AdEngine2.getProvider(['LEFT_SKYSCRAPER_2']), 'Evolve', 'LEFT_SKYSCRAPER_2');
});
