describe('AdProviderLater', function(){
	it('fillInSlot pushes to the passed queue', function() {
		var logMock = function() {},
			queueMock = [],
			adProviderLater;

		queueMock.push(['item0']);

		adProviderLater = AdProviderLater(logMock, queueMock);

		adProviderLater.fillInSlot('item1');
		adProviderLater.fillInSlot('item2');

		queueMock.push(['item3']);

		expect(queueMock.length).toBe(4);
		expect(queueMock[0]).toEqual(['item0']);
		expect(queueMock[1]).toEqual(['item1']);
		expect(queueMock[2]).toEqual(['item2']);
		expect(queueMock[3]).toEqual(['item3']);
	});
});
