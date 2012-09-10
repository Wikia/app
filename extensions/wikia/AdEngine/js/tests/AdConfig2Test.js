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
	window.wgContentLanguage = 'not de';
	window.testUseCountry = 'error';

	equal(AdConfig2.getProvider(['foo']), 'AdDriver2', 'AdDriver2');
});

// TODO may be refactored to AdProviderEvolve
test('getProvider evolve AU', function() {
	// setup
	window.testUseCountry = 'AU';

	equal(AdConfig2.getProvider(['TOP_LEADERBOARD']), 'Evolve', 'TOP_LEADERBOARD');
	equal(AdConfig2.getProvider(['TOP_RIGHT_BOXAD']), 'Evolve', 'TOP_RIGHT_BOXAD');
	equal(AdConfig2.getProvider(['LEFT_SKYSCRAPER_2']), 'Evolve', 'LEFT_SKYSCRAPER_2');

	notEqual(AdConfig2.getProvider(['INCONTENT_BOXAD_1']), 'Evolve', 'INCONTENT_BOXAD_1');
	notEqual(AdConfig2.getProvider(['PREFOOTER_LEFT_BOXAD']), 'Evolve', 'PREFOOTER_LEFT_BOXAD');
	notEqual(AdConfig2.getProvider(['PREFOOTER_RIGHT_BOXAD']), 'Evolve', 'PREFOOTER_RIGHT_BOXAD');
});

// TODO may be refactored to AdProviderEvolve
test('getProvider evolve not AU', function() {
	// setup
	window.testUseCountry = 'not AU';

	notEqual(AdConfig2.getProvider(['TOP_LEADERBOARD']), 'Evolve', 'TOP_LEADERBOARD');
	notEqual(AdConfig2.getProvider(['TOP_RIGHT_BOXAD']), 'Evolve', 'TOP_RIGHT_BOXAD');
	notEqual(AdConfig2.getProvider(['LEFT_SKYSCRAPER_2']), 'Evolve', 'LEFT_SKYSCRAPER_2');
});

// TODO may be refactored to AdProviderGamePro
test('getProvider GamePro de', function() {
	// setup
	window.wgContentLanguage = 'de';

	equal(AdConfig2.getProvider(['TOP_LEADERBOARD']), 'GamePro', 'TOP_LEADERBOARD');
	equal(AdConfig2.getProvider(['TOP_RIGHT_BOXAD']), 'GamePro', 'TOP_RIGHT_BOXAD');
	equal(AdConfig2.getProvider(['LEFT_SKYSCRAPER_2']), 'GamePro', 'LEFT_SKYSCRAPER_2');
	equal(AdConfig2.getProvider(['PREFOOTER_LEFT_BOXAD']), 'GamePro', 'PREFOOTER_LEFT_BOXAD');

	notEqual(AdConfig2.getProvider(['INCONTENT_BOXAD_1']), 'GamePro', 'INCONTENT_BOXAD_1');
	notEqual(AdConfig2.getProvider(['PREFOOTER_RIGHT_BOXAD']), 'GamePro', 'PREFOOTER_RIGHT_BOXAD');
});

// TODO may be refactored to AdProviderGamePro
test('getProvider GamePro not de', function() {
	// setup
	window.wgContentLanguage = 'not de';

	notEqual(AdConfig2.getProvider(['TOP_LEADERBOARD']), 'GamePro', 'TOP_LEADERBOARD');
	notEqual(AdConfig2.getProvider(['TOP_RIGHT_BOXAD']), 'GamePro', 'TOP_RIGHT_BOXAD');
	notEqual(AdConfig2.getProvider(['LEFT_SKYSCRAPER_2']), 'GamePro', 'LEFT_SKYSCRAPER_2');
	notEqual(AdConfig2.getProvider(['PREFOOTER_LEFT_BOXAD']), 'GamePro', 'PREFOOTER_LEFT_BOXAD');
});
