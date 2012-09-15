/*
@test-framework QUnit
 @test-require-asset resources/wikia/modules/querystring.js
 @test-require-asset resources/wikia/modules/cookies.js
 @test-require-asset resources/wikia/modules/log.js
 @test-require-asset extensions/wikia/WikiaTracker/js/WikiaTracker.js
 @test-require-asset extensions/wikia/AdEngine/ghost/gw-11.6.7/lib/gw.js
@test-require-asset extensions/wikia/AdEngine/js/AdProviderGamePro.js
*/
module('AdProviderGamePro');

test('rebuildKV', function() {
	var adProviderGamePro = AdProviderGamePro(WikiaTracker, Wikia.log, window, ghostwriter, document);

    equal(adProviderGamePro.rebuildKV('egnre=action;egnre=adventure;egnre=drama;egnre=scifi;media=tv'), 'egnre=action,adventure,drama,scifi;media=tv', 'egnre=action;egnre=adventure;egnre=drama;egnre=scifi;media=tv');
});

test('canHandleSlot GamePro de', function() {
	// setup
	var adProviderGamePro = AdProviderGamePro(WikiaTracker, Wikia.log, window, ghostwriter, document);

	window.wgContentLanguage = 'de';

	equal(adProviderGamePro.canHandleSlot(['HOME_TOP_LEADERBOARD']), true, 'de slot HOME_TOP_LEADERBOARD');
	equal(adProviderGamePro.canHandleSlot(['HOME_TOP_RIGHT_BOXAD']), true, 'de slot HOME_TOP_RIGHT_BOXAD');
	equal(adProviderGamePro.canHandleSlot(['INCONTENT_BOXAD_1']), false, 'de slot INCONTENT_BOXAD_1');
});

test('getProvider GamePro not de', function() {
	// setup
	var adProviderGamePro = AdProviderGamePro(WikiaTracker, Wikia.log, window, ghostwriter, document);

	window.wgContentLanguage = 'pl';

	equal(adProviderGamePro.canHandleSlot(['HOME_TOP_LEADERBOARD']), false, 'pl slot HOME_TOP_LEADERBOARD');
	equal(adProviderGamePro.canHandleSlot(['HOME_TOP_RIGHT_BOXAD']), false, 'pl slot HOME_TOP_RIGHT_BOXAD');
	equal(adProviderGamePro.canHandleSlot(['INCONTENT_BOXAD_1']), false, 'pl slot INCONTENT_BOXAD_1');

	window.wgContentLanguage = 'en';

	equal(adProviderGamePro.canHandleSlot(['HOME_TOP_LEADERBOARD']), false, 'en slot HOME_TOP_LEADERBOARD');
	equal(adProviderGamePro.canHandleSlot(['HOME_TOP_RIGHT_BOXAD']), false, 'en slot HOME_TOP_RIGHT_BOXAD');
	equal(adProviderGamePro.canHandleSlot(['INCONTENT_BOXAD_1']), false, 'en slot INCONTENT_BOXAD_1');
});
