/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdProviderNull.js
 */

module('AdProviderNull');

test('canHandleSlot', function() {
	// setup
	var logMock = function() {}
		, adProviderNull = AdProviderNull(logMock);

	equal(adProviderNull.canHandleSlot(['foo']), true, 'canHandleSlot returns true');
});

test('fillInSlot', function() {
	// setup
	var logMock = function() {}
		, adProviderNull = AdProviderNull(logMock);

	equal(typeof(adProviderNull.fillInSlot), 'function', 'fillInSlot method defined');
});
