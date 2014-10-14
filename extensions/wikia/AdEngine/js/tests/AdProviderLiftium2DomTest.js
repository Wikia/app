/**
 * @test-require-asset extensions/wikia/AdEngine/js/AdProviderLiftium2Dom.js
 */

describe('AdProviderLiftium2Dom', function(){
	it('canHandleSlot', function() {
		var scriptWriterMock
			, trackerMock
			, logMock = function() {}
			, documentMock
			, slotTweakerMock
			, LiftiumMock
			, adProviderLiftium2Dom;

		adProviderLiftium2Dom = AdProviderLiftium2Dom(
			trackerMock, logMock, documentMock, slotTweakerMock, LiftiumMock, scriptWriterMock
		);

		expect(adProviderLiftium2Dom.canHandleSlot(['foo'])).toBeFalsy('foo');
		expect(adProviderLiftium2Dom.canHandleSlot(['TOP_RIGHT_BUTTON'])).toBeFalsy('TOP_RIGHT_BUTTON');
		expect(adProviderLiftium2Dom.canHandleSlot(['HOME_TOP_RIGHT_BUTTON'])).toBeFalsy('HOME_TOP_RIGHT_BUTTON');
		expect(adProviderLiftium2Dom.canHandleSlot(['TOP_LEADERBOARD'])).toBeTruthy('TOP_LEADERBOARD');
		expect(adProviderLiftium2Dom.canHandleSlot(['TOP_RIGHT_BOXAD'])).toBeTruthy('TOP_RIGHT_BOXAD');
	});
});