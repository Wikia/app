/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.utils.sampler', function () {
	'use strict';

	var mocks = {
			qs: {
				getVal: function () {
					return '';
				}
			},
			QueryString: function () {
				return mocks.qs;
			}
		},
		testCases = [
			{ randomResult: 0.01, expectedResult: true },
			{ randomResult: 0.05, expectedResult: true },
			{ randomResult: 0.09, expectedResult: true },
			{ randomResult: 0.1, expectedResult: true },
			{ randomResult: 0.15, expectedResult: true },
			{ randomResult: 0.19999999, expectedResult: true},
			{ randomResult: 0.2, expectedResult: false },
			{ randomResult: 0.3, expectedResult: false },
			{ randomResult: 0.4, expectedResult: false },
			{ randomResult: 0.5, expectedResult: false },
			{ randomResult: 0.6, expectedResult: false },
			{ randomResult: 0.7, expectedResult: false },
			{ randomResult: 0.8, expectedResult: false },
			{ randomResult: 0.9, expectedResult: false },
			{ randomResult: 1, expectedResult: false }
		];

	function getModule() {
		return modules['ext.wikia.adEngine.utils.sampler'](mocks.QueryString);
	}

	function mockRandom(randomResult) {
		spyOn(Math, 'random');
		Math.random.and.returnValue(randomResult);
	}

	function mockQueryString(value) {
		spyOn(mocks.qs, 'getVal');
		mocks.qs.getVal.and.returnValue(value);
	}

	testCases.forEach(function (testCase) {
		it('Should return: ' + testCase.expectedResult.toString() + ' for mocked random result: ' + testCase.randomResult, function () {
			mockRandom(testCase.randomResult);

			var sampler = getModule();
			expect(sampler.sample('test', 2, 10)).toEqual(testCase.expectedResult);
		});
	});

	it('Should return true if it is ignored by query param', function () {
		mockRandom(0.5);
		mockQueryString('test');

		var sampler = getModule();
		expect(sampler.sample('test', 2, 10)).toBeTruthy();
	});

	it('Should return false if in query param is different value', function () {
		mockRandom(0.5);
		mockQueryString('different_test');

		var sampler = getModule();
		expect(sampler.sample('test', 2, 10)).toBeFalsy();
	});

	it('Should return true for two samplers forced by query param', function () {
		mockRandom(0.5);
		mockQueryString('a,b');

		var sampler = getModule();
		expect(sampler.sample('a', 2, 10)).toBeTruthy();
		expect(sampler.sample('b', 2, 10)).toBeTruthy();
	});

});
