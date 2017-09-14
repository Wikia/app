/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.priceGranularityHelper', function () {
	'use strict';

	var defaultCpms = [
			// test 0 -> 0.00
			{actual: 0, expected: '0.00'},
			// test <0.01, 0.05) -> increment 0.01
			{actual: 0.01, expected: '0.01'},
			{actual: 0.02, expected: '0.01'},
			{actual: 0.03, expected: '0.01'},
			{actual: 0.04, expected: '0.01'},
			// test <0.05, 5.00) -> increment 0.05
			{actual: 0.05, expected: '0.05'},
			{actual: 0.06, expected: '0.05'},
			{actual: 0.11, expected: '0.10'},
			{actual: 4.99, expected: '4.95'},
			// test <5.00, 10.00) -> increment 0.10
			{actual: 5.00, expected: '5.00'},
			{actual: 5.01, expected: '5.00'},
			{actual: 5.11, expected: '5.10'},
			{actual: 9.99, expected: '9.90'},
			// test <10.00, 20.00) -> increment 0.5
			{actual: 10.00, expected: '10.00'},
			{actual: 10.01, expected: '10.00'},
			{actual: 10.51, expected: '10.50'},
			{actual: 11.21, expected: '11.00'},
			{actual: 19.99, expected: '19.50'},
			// test <20.00, infinity) -> return 20.00
			{actual: 20.00, expected: '20.00'},
			{actual: 100.00, expected: '20.00'}
		],
		customMaxCpms = [
			// test 0 -> 0.00
			{actual: 0, expected: '0.00'},
			// test <0.01, 0.05) -> increment 0.01
			{actual: 0.01, expected: '0.01'},
			{actual: 0.02, expected: '0.01'},
			{actual: 0.03, expected: '0.01'},
			{actual: 0.04, expected: '0.01'},
			// test <0.05, 5.00) -> increment 0.05
			{actual: 0.05, expected: '0.05'},
			{actual: 0.06, expected: '0.05'},
			{actual: 0.11, expected: '0.10'},
			{actual: 4.99, expected: '4.95'},
			// test <5.00, 10.00) -> increment 0.10
			{actual: 5.00, expected: '5.00'},
			{actual: 5.01, expected: '5.00'},
			{actual: 5.11, expected: '5.10'},
			{actual: 9.99, expected: '9.90'},
			// test <10.00, 20.00) -> increment 0.5
			{actual: 10.00, expected: '10.00'},
			{actual: 10.01, expected: '10.00'},
			{actual: 10.51, expected: '10.50'},
			{actual: 11.21, expected: '11.00'},
			{actual: 19.99, expected: '19.50'},
			// test <20.00, 50.00) -> increment 1
			{actual: 20.00, expected: '20.00'},
			{actual: 45.00, expected: '45.00'},
			{actual: 45.01, expected: '45.00'},
			{actual: 45.99, expected: '45.00'},
			// test <50.00, infinity) -> return 50.00
			{actual: 100.00, expected: '50.00'}
		],
		priceGranularityHelper;

	function getPriceGranularityHelper() {
		return modules['ext.wikia.adEngine.lookup.prebid.priceGranularityHelper']();
	}

	beforeEach(function () {
		priceGranularityHelper = getPriceGranularityHelper();
	});

	defaultCpms.forEach(function (cpm) {
		it('price granularity helper should transform ' + cpm.actual + ' to ' + cpm.expected, function () {
			var actual = priceGranularityHelper.transformPriceFromCpm(cpm.actual);

			expect(actual).toEqual(cpm.expected);
		});
	});

	customMaxCpms.forEach(function (cpm) {
		it('price granularity helper with custom MaxCpm: 50 should transform ' + cpm.actual + ' to ' + cpm.expected, function () {
			var actual = priceGranularityHelper.transformPriceFromCpm(cpm.actual, 50);

			expect(actual).toEqual(cpm.expected);
		});
	});
});
