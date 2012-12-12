/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdProviderLiftium2Dom.js
 */

module('AdProviderLiftium2Dom');

test('canHandleSlot', function() {
	var scriptWriterMock
		, wikiaTrackerMock
		, logMock = function() {}
		, documentMock
		, slotTweakerMock
		, LiftiumMock
		, adProviderLiftium2Dom;

	adProviderLiftium2Dom = AdProviderLiftium2Dom(
		wikiaTrackerMock, logMock, documentMock, slotTweakerMock, LiftiumMock, scriptWriterMock
	);

    equal(adProviderLiftium2Dom.canHandleSlot(['foo']), false, 'foo');
    equal(adProviderLiftium2Dom.canHandleSlot(['TOP_RIGHT_BUTTON']), false, 'TOP_RIGHT_BUTTON');
    equal(adProviderLiftium2Dom.canHandleSlot(['HOME_TOP_RIGHT_BUTTON']), false, 'HOME_TOP_RIGHT_BUTTON');
    equal(adProviderLiftium2Dom.canHandleSlot(['TOP_LEADERBOARD']), true, 'TOP_LEADERBOARD');
    equal(adProviderLiftium2Dom.canHandleSlot(['TOP_RIGHT_BOXAD']), true, 'TOP_RIGHT_BOXAD');
});
