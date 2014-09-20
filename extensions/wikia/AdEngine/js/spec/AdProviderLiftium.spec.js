describe('AdProviderLiftium', function(){
	it('canHandleSlot', function() {
		var scriptWriterMock,
			logMock = function() {},
			windowMock = {},
			documentMock,
			slotTweakerMock,
			Liftium,
			adProviderLiftium;

		adProviderLiftium = modules['ext.wikia.adEngine.provider.liftium'](
			logMock, windowMock, documentMock, scriptWriterMock, slotTweakerMock
		);

		expect(adProviderLiftium.canHandleSlot(['foo'])).toBeFalsy('foo');
		expect(adProviderLiftium.canHandleSlot(['TOP_BUTTON_WIDE'])).toBeTruthy('TOP_BUTTON_WIDE');
		expect(adProviderLiftium.canHandleSlot(['TOP_LEADERBOARD'])).toBeTruthy('TOP_LEADERBOARD');
		expect(adProviderLiftium.canHandleSlot(['TOP_RIGHT_BOXAD'])).toBeTruthy('TOP_RIGHT_BOXAD');
	});
});
