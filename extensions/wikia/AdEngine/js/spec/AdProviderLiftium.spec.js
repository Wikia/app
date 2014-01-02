describe('AdProviderLiftium', function(){
	it('canHandleSlot', function() {
		var scriptWriterMock,
			logMock = function() {},
			documentMock,
			slotTweakerMock,
			LiftiumMock,
			adProviderLiftium;

		adProviderLiftium = AdProviderLiftium(
			logMock, documentMock, slotTweakerMock, LiftiumMock, scriptWriterMock
		);

		expect(adProviderLiftium.canHandleSlot(['foo'])).toBeFalsy('foo');
		expect(adProviderLiftium.canHandleSlot(['TOP_BUTTON_WIDE'])).toBeTruthy('TOP_BUTTON_WIDE');
		expect(adProviderLiftium.canHandleSlot(['TOP_LEADERBOARD'])).toBeTruthy('TOP_LEADERBOARD');
		expect(adProviderLiftium.canHandleSlot(['TOP_RIGHT_BOXAD'])).toBeTruthy('TOP_RIGHT_BOXAD');
	});
});
