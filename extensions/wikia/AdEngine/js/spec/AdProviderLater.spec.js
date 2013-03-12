describe('AdProviderLater', function(){
	it('fillInSlot pushes to the passed queue', function() {
		var logMock = function() {}
			, queueMock = []
			, adProviderLater;

		queueMock.push('item0');

		adProviderLater = AdProviderLater(logMock, queueMock);

		adProviderLater.fillInSlot('item1');
		adProviderLater.fillInSlot('item2');

		queueMock.push('item3');

		expect(queueMock.length).toBe(4);
		expect(queueMock[0]).toBe('item0');
		expect(queueMock[1]).toBe('item1');
		expect(queueMock[2]).toBe('item2');
		expect(queueMock[3]).toBe('item3');
	});
});