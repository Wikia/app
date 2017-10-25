/*global describe, expect, it, modules*/
describe('ext.wikia.adEngine.ml.model.linear', function () {
	'use strict';

	function getModule() {
		return modules['ext.wikia.adEngine.ml.model.linear']();
	}

	var testCases = [
		{
			data: {
				coefficients: [ 1, 1 ],
				intercept: -1
			},
			output: 1
		},
		{
			data: {
				coefficients: [ 1, 0 ],
				intercept: -2
			},
			output: 0
		}
	];

	it('Predict value based on coefficients and intercept', function () {
		testCases.forEach(function (testCase) {
			var lm = getModule().create(testCase.data.coefficients, testCase.data.intercept);

			expect(lm.predict([ 1, 1 ])).toBe(testCase.output);
		});
	});
});
