/*
@test-framework QUnit
 @test-require-asset resources/wikia/modules/querystring.js
 @test-require-asset resources/wikia/modules/cookies.js
 @test-require-asset resources/wikia/modules/log.js
 @test-require-asset extensions/wikia/WikiaTracker/js/WikiaTracker.js
 @test-require-asset extensions/wikia/AdEngine/ghost/gw-11.6.7/lib/gw.js
 @test-require-asset extensions/wikia/AdEngine/js/AdProviderEvolveRS.js
 @test-require-asset extensions/wikia/AdEngine/js/AdConfig2.js
*/
module('AdProviderEvolveRS');

test('canHandleSlot EvolveRS', function() {
	// setup
	var adProviderEvolveRS;

	adProviderEvolveRS = AdProviderEvolveRS(
		WikiaTracker, Wikia.log, window, ghostwriter, document
	);

	equal(adProviderEvolveRS.canHandleSlot(['INVISIBLE_1']), true, 'INVISIBLE_1');
	equal(adProviderEvolveRS.canHandleSlot(['TOP_LEADERBOARD']), false, 'TOP_LEADERBOARD');
});
