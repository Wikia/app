/**
 * @test-framework Jasmine
 * @test-require-asset extensions/wikia/AdEngine/js/AdProviderGamePro.js
 */

describe('AdProviderGamePro', function(){
	it('canHandleSlot GamePro de', function() {
		var logMock = function() {}
			, scriptWriterMock
			, wikiaDartMock
			, wikiaTrackerMock
			, windowMock = {wgInsideUnitTest: true, wgContentLanguage: 'de'}
			, documentMock
			, adProviderGamePro;

		adProviderGamePro = AdProviderGamePro(
			wikiaDartMock, scriptWriterMock, wikiaTrackerMock, logMock, windowMock, documentMock
		);

		expect(adProviderGamePro.canHandleSlot(['HOME_TOP_LEADERBOARD'])).toBeTruthy('de slot HOME_TOP_LEADERBOARD');
		expect(adProviderGamePro.canHandleSlot(['HOME_TOP_RIGHT_BOXAD'])).toBeTruthy('de slot HOME_TOP_RIGHT_BOXAD');
		expect(adProviderGamePro.canHandleSlot(['INCONTENT_BOXAD_1'])).toBeFalsy('de slot INCONTENT_BOXAD_1');
	});

	it('canHandleSlot GamePro outside de', function() {
		var logMock = function() {}
			, scriptWriterMock
			, wikiaTrackerMock
			, windowMock = {wgInsideUnitTest: true}
			, documentMock
			, adProviderGamePro
			, wikiaDartMock;

		adProviderGamePro = AdProviderGamePro(
			wikiaDartMock, scriptWriterMock, wikiaTrackerMock, logMock, windowMock, documentMock
		);

		windowMock.wgContentLanguage = 'pl';

		expect(adProviderGamePro.canHandleSlot(['HOME_TOP_LEADERBOARD'])).toBeTruthy('pl slot HOME_TOP_LEADERBOARD');
		expect(adProviderGamePro.canHandleSlot(['HOME_TOP_RIGHT_BOXAD'])).toBeTruthy('pl slot HOME_TOP_RIGHT_BOXAD');
		expect(adProviderGamePro.canHandleSlot(['INCONTENT_BOXAD_1'])).toBeFalsy('pl slot INCONTENT_BOXAD_1');

		windowMock.wgContentLanguage = 'en';

		expect(adProviderGamePro.canHandleSlot(['HOME_TOP_LEADERBOARD'])).toBeTruthy('en slot HOME_TOP_LEADERBOARD');
		expect(adProviderGamePro.canHandleSlot(['HOME_TOP_RIGHT_BOXAD'])).toBeTruthy('en slot HOME_TOP_RIGHT_BOXAD');
		expect(adProviderGamePro.canHandleSlot(['INCONTENT_BOXAD_1'])).toBeFalsy('en slot INCONTENT_BOXAD_1');
	});
});