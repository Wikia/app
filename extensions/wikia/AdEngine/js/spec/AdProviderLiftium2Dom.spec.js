describe('AdProviderLiftium2Dom', function(){
	it('canHandleSlot', function() {
		var scriptWriterMock,
			logMock = function() {},
			documentMock,
			slotTweakerMock,
			LiftiumMock,
			adProviderLiftium2Dom;

		adProviderLiftium2Dom = AdProviderLiftium2Dom(
			logMock, documentMock, slotTweakerMock, LiftiumMock, scriptWriterMock
		);

		expect(adProviderLiftium2Dom.canHandleSlot(['foo'])).toBeFalsy('foo');
		expect(adProviderLiftium2Dom.canHandleSlot(['TOP_BUTTON_WIDE'])).toBeTruthy('TOP_BUTTON_WIDE');
		expect(adProviderLiftium2Dom.canHandleSlot(['TOP_LEADERBOARD'])).toBeTruthy('TOP_LEADERBOARD');
		expect(adProviderLiftium2Dom.canHandleSlot(['TOP_RIGHT_BOXAD'])).toBeTruthy('TOP_RIGHT_BOXAD');
	});
});
