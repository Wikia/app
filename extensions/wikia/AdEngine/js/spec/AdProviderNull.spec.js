describe('AdProviderNull', function(){
	it('canHandleSlot', function() {
		// setup
		var logMock = function() {},
			slotTweakerMock,
			adProviderNull = modules['ext.wikia.adEngine.provider.null'](logMock, slotTweakerMock);

		expect(adProviderNull.canHandleSlot(['foo'])).toBeTruthy('canHandleSlot returns true');
	});

	it('fillInSlot', function() {
		// setup
		var logMock = function() {},
			slotTweakerMock,
			adProviderNull = modules['ext.wikia.adEngine.provider.null'](logMock, slotTweakerMock);

		expect(typeof(adProviderNull.fillInSlot)).toBe('function', 'fillInSlot method defined');
	});
});