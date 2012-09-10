/*
@test-framework QUnit
 @test-require-asset resources/wikia/modules/querystring.js
 @test-require-asset resources/wikia/modules/cookies.js
 @test-require-asset resources/wikia/modules/log.js
 @test-require-asset extensions/wikia/WikiaTracker/js/WikiaTracker.js
 @test-require-asset extensions/wikia/AdEngine/ghost/gw-11.6.7/lib/gw.js
@test-require-asset extensions/wikia/AdEngine/AdProviderEvolve.js
*/
module('AdProviderEvolve');

test('sanitizeSlotname', function() {
    equal(AdProviderEvolve.sanitizeSlotname('foo'), '', 'foo');
    equal(AdProviderEvolve.sanitizeSlotname('TOP_LEADERBOARD'), 'TOP_LEADERBOARD', 'TOP_LEADERBOARD');
    equal(AdProviderEvolve.sanitizeSlotname('=TOP_LEADERBOARD;ord=1'), 'TOP_LEADERBOARD', '=TOP_LEADERBOARD;ord=1');
});

test('getUrl', function() {
	var expected = 'http://n4403ad.doubleclick.net/adj/gn.wikia4.com/home;sect=home;mtfInline=true;pos=TOP_LEADERBOARD;sz=728x90;dcopt=ist;type=pop;type=int;tile=1;ord=1234567890?';
	expected = expected.replace(/;ord=[0-9]+\?$/, '');

	var actual = AdProviderEvolve.getUrl('TOP_LEADERBOARD', '728x90');
	actual = actual.replace(/;ord=[0-9]+\?$/, '');

	equal(actual, expected, 'TOP_LEADERBOARD');
});