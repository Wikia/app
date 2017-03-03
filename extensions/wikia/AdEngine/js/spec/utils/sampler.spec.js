/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.utils.sampler', function () {
	'use strict';

	function getModule() {
		return modules['ext.wikia.adEngine.utils.sampler']();
	}

	var testCases = [
		// Math.random, is sampled
		[0.01, true],
		[0.05, true],
		[0.09, true],
		[0.1, true],
		[0.15, true],
		[0.19999999, true],
		[0.2, false],
		[0.3, false],
		[0.4, false],
		[0.5, false],
		[0.6, false],
		[0.7, false],
		[0.8, false],
		[0.9, false],
		[1, false]
	];

	testCases.forEach(function (testCase) {
		var randomResult = testCase[0],
			testResult = testCase[1];

		it('Should return: ' + testResult.toString() + ' for mocked random result: ' + randomResult, function () {
			spyOn(Math, 'random');
			Math.random.and.returnValue(randomResult);

			var sampler = getModule();
			expect(sampler.sample(2, 10)).toEqual(testResult);
		});
	});

});
