/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdProviderGamePro.js
 */

module('AdProviderGamePro');

test('rebuildKV', function() {
	var logMock = function() {}
		, scriptWriterMock
		, wikiaTrackerMock
		, windowMock = {wgInsideUnitTest: true}
		, documentMock
		, adProviderGamePro;

	adProviderGamePro = AdProviderGamePro(
		scriptWriterMock, wikiaTrackerMock, logMock, windowMock, documentMock
	);

	console.log(adProviderGamePro);

    equal(adProviderGamePro.rebuildKV('egnre=action;egnre=adventure;egnre=drama;egnre=scifi;media=tv'), 'egnre=action,adventure,drama,scifi;media=tv', 'egnre=action;egnre=adventure;egnre=drama;egnre=scifi;media=tv');
});

test('canHandleSlot GamePro de', function() {
	var logMock = function() {}
		, scriptWriterMock
		, wikiaTrackerMock
		, windowMock = {wgInsideUnitTest: true, wgContentLanguage: 'de'}
		, documentMock
		, adProviderGamePro;

	adProviderGamePro = AdProviderGamePro(
		scriptWriterMock, wikiaTrackerMock, logMock, windowMock, documentMock
	);

	equal(adProviderGamePro.canHandleSlot(['HOME_TOP_LEADERBOARD']), true, 'de slot HOME_TOP_LEADERBOARD');
	equal(adProviderGamePro.canHandleSlot(['HOME_TOP_RIGHT_BOXAD']), true, 'de slot HOME_TOP_RIGHT_BOXAD');
	equal(adProviderGamePro.canHandleSlot(['INCONTENT_BOXAD_1']), false, 'de slot INCONTENT_BOXAD_1');
});

test('canHandleSlot GamePro outside de', function() {
	var logMock = function() {}
		, scriptWriterMock
		, wikiaTrackerMock
		, windowMock = {wgInsideUnitTest: true}
		, documentMock
		, adProviderGamePro;

	adProviderGamePro = AdProviderGamePro(
		scriptWriterMock, wikiaTrackerMock, logMock, windowMock, documentMock
	);

	windowMock.wgContentLanguage = 'pl';

	equal(adProviderGamePro.canHandleSlot(['HOME_TOP_LEADERBOARD']), false, 'pl slot HOME_TOP_LEADERBOARD');
	equal(adProviderGamePro.canHandleSlot(['HOME_TOP_RIGHT_BOXAD']), false, 'pl slot HOME_TOP_RIGHT_BOXAD');
	equal(adProviderGamePro.canHandleSlot(['INCONTENT_BOXAD_1']), false, 'pl slot INCONTENT_BOXAD_1');

	windowMock.wgContentLanguage = 'en';

	equal(adProviderGamePro.canHandleSlot(['HOME_TOP_LEADERBOARD']), false, 'en slot HOME_TOP_LEADERBOARD');
	equal(adProviderGamePro.canHandleSlot(['HOME_TOP_RIGHT_BOXAD']), false, 'en slot HOME_TOP_RIGHT_BOXAD');
	equal(adProviderGamePro.canHandleSlot(['INCONTENT_BOXAD_1']), false, 'en slot INCONTENT_BOXAD_1');
});
