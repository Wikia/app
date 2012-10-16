/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/EvolveHelper.js
 */

module('EvolveHelper');

test('getSect', function() {
	var logMock = function() {}
		, windowMock = {}
	;

	evolveHelper = EvolveHelper(logMock, windowMock);

	windowMock.wgDBname = null;
	windowMock.wgDartCustomKeyValues = null;
	windowMock.cscoreCat = null;

	equal(evolveHelper.getSect(), 'ros', 'ros');

	windowMock.wgDartCustomKeyValues = 'foo=bar;media=tv';
	windowMock.cscoreCat = 'Entertainment';

	equal(evolveHelper.getSect(), 'tv', 'tv entertainment');

	windowMock.wgDartCustomKeyValues = 'foo=bar';
	windowMock.cscoreCat = 'Entertainment';

	equal(evolveHelper.getSect(), 'entertainment', 'foo entertainment');

	windowMock.wgDartCustomKeyValues = 'foo=bar;media=movie';
	windowMock.cscoreCat = 'Entertainment';

	equal(evolveHelper.getSect(), 'movies', 'movie entertainment');

});
