/*
@test-framework QUnit
 @test-require-asset resources/wikia/libraries/my.class/my.class.js
 @test-require-asset resources/wikia/modules/querystring.js
 @test-require-asset resources/wikia/modules/cookies.js
 @test-require-asset resources/wikia/modules/log.js
 @test-require-asset extensions/wikia/AdEngine/AdProviderAdEngine2.js
@test-require-asset extensions/wikia/AdEngine/AdProviderEvolve.js
*/
module('AdProviderEvolve');

test('sanitizeSlotname', function() {
	var ap = new AdProviderEvolve;

    equal(ap.sanitizeSlotname('foo'), '', 'foo');
    equal(ap.sanitizeSlotname('TOP_LEADERBOARD'), 'TOP_LEADERBOARD', 'TOP_LEADERBOARD');
    equal(ap.sanitizeSlotname('=TOP_LEADERBOARD;ord=1'), 'TOP_LEADERBOARD', '=TOP_LEADERBOARD;ord=1');
});

test('getUrl', function() {
	var ap = new AdProviderEvolve;
	ap.ord = 1;

	equal(ap.getUrl('TOP_LEADERBOARD', '728x90'), 'http://n4403ad.doubleclick.net/adj/gn.wikia4.com/home;sect=home;mtfInline=true;pos=TOP_LEADERBOARD;sz=728x90;dcopt=ist;type=pop;type=int;tile=1;ord=1?', 'TOP_LEADERBOARD');
});