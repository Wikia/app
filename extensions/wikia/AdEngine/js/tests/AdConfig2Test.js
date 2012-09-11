/*
@test-framework QUnit
 @test-require-asset resources/wikia/modules/querystring.js
 @test-require-asset resources/wikia/modules/cookies.js
 @test-require-asset resources/wikia/modules/log.js
 @test-require-asset extensions/wikia/AdEngine/ghost/gw-11.6.7/lib/gw.js
 @test-require-asset extensions/wikia/WikiaTracker/js/WikiaTracker.js
 @test-require-asset extensions/wikia/AdEngine/js/AdProviderEvolve.js
 @test-require-asset extensions/wikia/AdEngine/js/AdProviderGamePro.js
 @test-require-asset extensions/wikia/AdEngine/js/AdProviderAdDriver2.js
 @test-require-asset extensions/wikia/AdEngine/js/AdConfig2.js
*/
module('AdConfig2');

test('getProvider failsafe', function() {
	// setup
	window.wgContentLanguage = 'not de';
	window.testUseCountry = 'error';

	equal(AdConfig2.getProvider(['foo']).name, 'AdDriver2', 'AdDriver2');
});

// TODO may be refactored to AdProviderEvolve
test('getProvider evolve AU', function() {
	// setup
	window.testUseCountry = 'AU';

	equal(AdConfig2.getProvider(['TOP_LEADERBOARD']).name, 'Evolve', 'TOP_LEADERBOARD');
	equal(AdConfig2.getProvider(['TOP_RIGHT_BOXAD']).name, 'Evolve', 'TOP_RIGHT_BOXAD');
	equal(AdConfig2.getProvider(['LEFT_SKYSCRAPER_2']).name, 'Evolve', 'LEFT_SKYSCRAPER_2');

	notEqual(AdConfig2.getProvider(['INCONTENT_BOXAD_1']).name, 'Evolve', 'INCONTENT_BOXAD_1');
	notEqual(AdConfig2.getProvider(['PREFOOTER_LEFT_BOXAD']).name, 'Evolve', 'PREFOOTER_LEFT_BOXAD');
	notEqual(AdConfig2.getProvider(['PREFOOTER_RIGHT_BOXAD']).name, 'Evolve', 'PREFOOTER_RIGHT_BOXAD');
});

// TODO may be refactored to AdProviderEvolve
test('getProvider evolve not AU', function() {
	// setup
	window.testUseCountry = 'not AU';

	notEqual(AdConfig2.getProvider(['TOP_LEADERBOARD']).name, 'Evolve', 'TOP_LEADERBOARD');
	notEqual(AdConfig2.getProvider(['TOP_RIGHT_BOXAD']).name, 'Evolve', 'TOP_RIGHT_BOXAD');
	notEqual(AdConfig2.getProvider(['LEFT_SKYSCRAPER_2']).name, 'Evolve', 'LEFT_SKYSCRAPER_2');
});

// TODO may be refactored to AdProviderGamePro
test('getProvider GamePro de', function() {
	// setup
	window.wgContentLanguage = 'de';

	equal(AdConfig2.getProvider(['TOP_LEADERBOARD']).name, 'GamePro', 'TOP_LEADERBOARD');
	equal(AdConfig2.getProvider(['TOP_RIGHT_BOXAD']).name, 'GamePro', 'TOP_RIGHT_BOXAD');
	equal(AdConfig2.getProvider(['LEFT_SKYSCRAPER_2']).name, 'GamePro', 'LEFT_SKYSCRAPER_2');
	equal(AdConfig2.getProvider(['PREFOOTER_LEFT_BOXAD']).name, 'GamePro', 'PREFOOTER_LEFT_BOXAD');

	notEqual(AdConfig2.getProvider(['INCONTENT_BOXAD_1']).name, 'GamePro', 'INCONTENT_BOXAD_1');
	notEqual(AdConfig2.getProvider(['PREFOOTER_RIGHT_BOXAD']).name, 'GamePro', 'PREFOOTER_RIGHT_BOXAD');
});

// TODO may be refactored to AdProviderGamePro
test('getProvider GamePro not de', function() {
	// setup
	window.wgContentLanguage = 'not de';

	notEqual(AdConfig2.getProvider(['TOP_LEADERBOARD']).name, 'GamePro', 'TOP_LEADERBOARD');
	notEqual(AdConfig2.getProvider(['TOP_RIGHT_BOXAD']).name, 'GamePro', 'TOP_RIGHT_BOXAD');
	notEqual(AdConfig2.getProvider(['LEFT_SKYSCRAPER_2']).name, 'GamePro', 'LEFT_SKYSCRAPER_2');
	notEqual(AdConfig2.getProvider(['PREFOOTER_LEFT_BOXAD']).name, 'GamePro', 'PREFOOTER_LEFT_BOXAD');
});
