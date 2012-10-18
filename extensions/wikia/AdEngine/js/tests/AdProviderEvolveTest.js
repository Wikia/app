/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdProviderEvolve.js
 */

module('AdProviderEvolve');

// dart has problems with sending back scripts based on key-val %p
// http://ad.doubleclick.net/adj/wka.gaming/_starcraft/article;s0=gaming;s1=_starcraft;dmn=wikia-devcom;pos=TOP_LEADERBOARD;ord=7121786175
// yields window.AdEngine2.hop('=TOP_LEADERBOARD;ord=7121786175');
// instead of window.AdEngine2.hop('TOP_LEADERBOARD');
test('sanitizeSlotname', function() {
	var wikiaTrackerMock
		, logMock = function() {}
		, scriptWriterMock
		, windowMock = {wgInsideUnitTest: true}
		, documentMock
		, kruxMock
		, evolveHelperMock = {}
		, adProviderEvolve;

	adProviderEvolve = AdProviderEvolve(
		scriptWriterMock, wikiaTrackerMock, logMock, windowMock, documentMock, kruxMock, evolveHelperMock
	);

    equal(adProviderEvolve.sanitizeSlotname('foo'), '', 'foo');
    equal(adProviderEvolve.sanitizeSlotname('TOP_LEADERBOARD'), 'TOP_LEADERBOARD', 'TOP_LEADERBOARD');
    equal(adProviderEvolve.sanitizeSlotname('=TOP_LEADERBOARD;ord=1'), 'TOP_LEADERBOARD', '=TOP_LEADERBOARD;ord=1');
});

test('getUrl', function() {
	var wikiaTrackerMock
		, logMock = function() {}
		, scriptWriterMock
		, windowMock = {wgInsideUnitTest: true}
		, documentMock
		, kruxMock = {}
		, evolveHelperMock = {getSect: function() {return 'randomsection';}}
		, adProviderEvolve
		, expected
		, actual
	;

	adProviderEvolve = AdProviderEvolve(
		scriptWriterMock, wikiaTrackerMock, logMock, windowMock, documentMock, kruxMock, evolveHelperMock
	);

	windowMock.wgDBname = null;
	windowMock.wgDartCustomKeyValues = null;
	windowMock.cscoreCat = null;

	expected = 'http://n4403ad.doubleclick.net/adj/gn.wikia4.com/randomsection;sect=randomsection;mtfInline=true;pos=TOP_LEADERBOARD;sz=728x90;dcopt=ist;type=pop;type=int;tile=1;ord=1234567890?';
	expected = expected.replace(/;ord=[0-9]+\?$/, ''); // ord is random cb

	actual = adProviderEvolve.getUrl('TOP_LEADERBOARD');
	actual = actual.replace(/;ord=[0-9]+\?$/, ''); // ord is random cb

	expected = 'http://n4403ad.doubleclick.net/adj/gn.wikia4.com/randomsection;sect=randomsection;mtfInline=true;pos=TOP_RIGHT_BOXAD;sz=300x250,300x600;type=pop;type=int;tile=2;ord=1234567890?';
	expected = expected.replace(/;ord=[0-9]+\?$/, ''); // ord is random cb

	actual = adProviderEvolve.getUrl('TOP_RIGHT_BOXAD');
	actual = actual.replace(/;ord=[0-9]+\?$/, ''); // ord is random cb

	equal(actual, expected, 'TOP_RIGHT_BOXAD');
});

test('Evolve canHandleSlot AU', function() {
	var wikiaTrackerMock
		, logMock = function() {}
		, scriptWriterMock
		, documentMock
		, windowMock = {wgInsideUnitTest: true}
		, kruxMock = {}
		, evolveHelperMock = {}
		, adProviderEvolve;

	adProviderEvolve = AdProviderEvolve(
		scriptWriterMock, wikiaTrackerMock, logMock, windowMock, documentMock, kruxMock, evolveHelperMock
	);

	equal(adProviderEvolve.canHandleSlot(['TOP_LEADERBOARD']), true, 'TOP_LEADERBOARD');
	equal(adProviderEvolve.canHandleSlot(['TOP_RIGHT_BOXAD']), true, 'TOP_RIGHT_BOXAD');
	equal(adProviderEvolve.canHandleSlot(['LEFT_SKYSCRAPER_2']), true, 'LEFT_SKYSCRAPER_2');

	equal(adProviderEvolve.canHandleSlot(['INCONTENT_BOXAD_1']), false, 'INCONTENT_BOXAD_1');
	equal(adProviderEvolve.canHandleSlot(['PREFOOTER_LEFT_BOXAD']), false, 'PREFOOTER_LEFT_BOXAD');
	equal(adProviderEvolve.canHandleSlot(['PREFOOTER_RIGHT_BOXAD']), false, 'PREFOOTER_RIGHT_BOXAD');
});
