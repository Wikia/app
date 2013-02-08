/**
 * @test-require-asset extensions/wikia/AdEngine/js/AdProviderNull.js
 */

describe('AdProviderNull', function(){
	it('canHandleSlot', function() {
		// setup
		var logMock = function() {}
			, adProviderNull = AdProviderNull(logMock);

		expect(adProviderNull.canHandleSlot(['foo'])).toBeTruthy('canHandleSlot returns true');
	});

	it('fillInSlot', function() {
		// setup
		var logMock = function() {}
			, adProviderNull = AdProviderNull(logMock);

		expect(typeof(adProviderNull.fillInSlot)).toBe('function', 'fillInSlot method defined');
	});
});