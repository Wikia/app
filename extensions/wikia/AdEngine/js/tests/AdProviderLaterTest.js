/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdProviderLater.js
 */

module('AdProviderLater');

test('fillInSlot pushes to the passed queue', function() {
	var logMock = function() {}
		, queueMock = []
		, adProviderLater;

	queueMock.push('item0');

	adProviderLater = AdProviderLater(logMock, queueMock);

	adProviderLater.fillInSlot('item1');
	adProviderLater.fillInSlot('item2');

	queueMock.push('item3');

	equal(queueMock.length, 4);
	equal(queueMock[0], 'item0');
	equal(queueMock[1], 'item1');
	equal(queueMock[2], 'item2');
	equal(queueMock[3], 'item3');
});
