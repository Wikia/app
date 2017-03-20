/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.priceGranularityHelper', function () {
	'use strict';

	var priceParsingHelper;

	function getPriceParsingHelper() {
		return modules['ext.wikia.adEngine.lookup.prebid.priceParsingHelper']();
	}

	beforeEach(function () {
		priceParsingHelper = getPriceParsingHelper();
	});

	it('Returs correct price from a title string', function() {
		var testCases = [
				{
					title: 'Prebid.js/Veles (VAST) - 640x480v [ve3150xx]',
					expected: 31.50
				},
				{
					title: 'Prebid.js/Veles (VAST) - 640x480v [ve3150ic]',
					expected: 31.50
				},
				{
					title: 'Prebid.js/Veles (VAST) - 640x480v [ve3150IC]',
					expected: 31.50
				},
				{
					title: 'Prebid.js/Veles (VAST) - 640x480v [ve3150LB]',
					expected: 31.50
				},
				{
					title: 'Prebid.js/Veles (VAST) - 640x480v ve0000xx',
					expected: 0
				},
				{
					title: 'Prebid.js/Veles (VAST) - 640x480v ve0001xx',
					expected: 0.01
				},
				{
					title: 'Prebid.js/Veles (VAST) - 640x480v [ve3150]',
					expected: 0
				},
				{
					title: 'Prebid.js/Veles (VAST) - 640x480v [ve3150x]',
					expected: 0
				},
				{
					title: 'Prebid.js/Veles (VAST) - 640x480v [ve315x]',
					expected: 0
				},
				{
					title: 'Prebid.js/Veles (VAST) - 640x480v [ve31509xx]',
					expected: 0
				}
			];

		testCases.forEach(function (testCase) {
			var price = priceParsingHelper.getPriceFromString(testCase.title);

			expect(price).toBe(testCase.expected);
		});
	})
});
