/**
 * @test-require-asset extensions/wikia/AdEngine/js/AdProviderGamePro.js
 */

describe('AdProviderGamePro', function(){
	it('canHandleSlot GamePro de', function() {
		var logMock = function() {}
			, scriptWriterMock
			, wikiaDartMock
			, trackerMock
			, windowMock = {wgInsideUnitTest: true, wgContentLanguage: 'de'}
			, adProviderGamePro
			, slotTweakerMock;

		adProviderGamePro = AdProviderGamePro(
			wikiaDartMock, scriptWriterMock, trackerMock, logMock, windowMock, slotTweakerMock
		);

		expect(adProviderGamePro.canHandleSlot(['HOME_TOP_LEADERBOARD'])).toBeTruthy('de slot HOME_TOP_LEADERBOARD');
		expect(adProviderGamePro.canHandleSlot(['HOME_TOP_RIGHT_BOXAD'])).toBeTruthy('de slot HOME_TOP_RIGHT_BOXAD');
		expect(adProviderGamePro.canHandleSlot(['INCONTENT_BOXAD_1'])).toBeFalsy('de slot INCONTENT_BOXAD_1');
	});

	it('canHandleSlot GamePro outside de', function() {
		var logMock = function() {}
			, scriptWriterMock
			, trackerMock
			, windowMock = {wgInsideUnitTest: true}
			, adProviderGamePro
			, wikiaDartMock
			, slotTweakerMock;


		adProviderGamePro = AdProviderGamePro(
			wikiaDartMock, scriptWriterMock, trackerMock, logMock, windowMock, slotTweakerMock
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
