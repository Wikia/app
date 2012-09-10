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

// dart has problems with sending back scripts based on key-val %p
// http://ad.doubleclick.net/adj/wka.gaming/_starcraft/article;s0=gaming;s1=_starcraft;dmn=wikia-devcom;pos=TOP_LEADERBOARD;ord=7121786175
// yields window.AdEngine2.hop('=TOP_LEADERBOARD;ord=7121786175');
// instead of window.AdEngine2.hop('TOP_LEADERBOARD');
test('sanitizeSlotname', function() {
    equal(AdProviderEvolve.sanitizeSlotname('foo'), '', 'foo');
    equal(AdProviderEvolve.sanitizeSlotname('TOP_LEADERBOARD'), 'TOP_LEADERBOARD', 'TOP_LEADERBOARD');
    equal(AdProviderEvolve.sanitizeSlotname('=TOP_LEADERBOARD;ord=1'), 'TOP_LEADERBOARD', '=TOP_LEADERBOARD;ord=1');
});

test('getUrl', function() {
	// setup
	window.wgDBname = null;
	window.wgWikiFactoryTagNames = null;
	window.cscoreCat = null;

	var expected = 'http://n4403ad.doubleclick.net/adj/gn.wikia4.com/ros;sect=ros;mtfInline=true;pos=TOP_LEADERBOARD;sz=728x90;dcopt=ist;type=pop;type=int;tile=1;ord=1234567890?';
	expected = expected.replace(/;ord=[0-9]+\?$/, ''); // ord is random cb

	var actual = AdProviderEvolve.getUrl('TOP_LEADERBOARD', '728x90');
	actual = actual.replace(/;ord=[0-9]+\?$/, ''); // ord is random cb

	equal(actual, expected, 'TOP_LEADERBOARD');
});

test('getSect', function() {
	// setup
	window.wgDBname = null;
	window.wgWikiFactoryTagNames = null;
	window.cscoreCat = null;

	equal(AdProviderEvolve.getSect(), 'ros', 'ros');

	window.wgWikiFactoryTagNames = ['tv'];
	window.cscoreCat = 'Entertainment';

	equal(AdProviderEvolve.getSect(), 'tv', 'tv entertainment');

	window.wgWikiFactoryTagNames = ['foo'];
	window.cscoreCat = 'Entertainment';

	equal(AdProviderEvolve.getSect(), 'entertainment', 'foo entertainment');
});