/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdProviderLiftium2.js
 */

module('AdProviderLiftium2');

test('canHandleSlot', function() {
	var scriptWriterMock
		, wikiaTrackerMock
		, logMock = function() {}
		, windowMock
		, adProviderLiftium2;

	adProviderLiftium2 = AdProviderLiftium2(
		scriptWriterMock, wikiaTrackerMock, logMock, windowMock
	);

    equal(adProviderLiftium2.canHandleSlot(['foo']), false, 'foo');
    equal(adProviderLiftium2.canHandleSlot(['TOP_RIGHT_BUTTON']), false, 'TOP_RIGHT_BUTTON');
    equal(adProviderLiftium2.canHandleSlot(['HOME_TOP_RIGHT_BUTTON']), false, 'HOME_TOP_RIGHT_BUTTON');
    equal(adProviderLiftium2.canHandleSlot(['TOP_LEADERBOARD']), true, 'TOP_LEADERBOARD');
    equal(adProviderLiftium2.canHandleSlot(['TOP_RIGHT_BOXAD']), true, 'TOP_RIGHT_BOXAD');
});
