/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdProviderEvolveRS.js
 */

module('AdProviderEvolveRS');

test('canHandleSlot EvolveRS', function() {
	// setup
	var wikiaTrackerMock
		, scriptWriterMock
		, logMock = function() {}
		, windowMock
		, ghostwriterMock
		, documentMock
		, adProviderEvolveRS;

	adProviderEvolveRS = AdProviderEvolveRS(
		scriptWriterMock, wikiaTrackerMock, logMock, windowMock, documentMock
	);

	equal(adProviderEvolveRS.canHandleSlot(['INVISIBLE_1']), true, 'INVISIBLE_1');
	equal(adProviderEvolveRS.canHandleSlot(['TOP_LEADERBOARD']), false, 'TOP_LEADERBOARD');
});
