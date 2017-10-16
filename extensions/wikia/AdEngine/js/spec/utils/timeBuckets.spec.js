/*global describe, it, expect, modules, beforeEach*/
describe('ext.wikia.adEngine.utils.timeBuckets', function () {
	'use strict';

	var testCases = [
		{
			time: 0.1,
			buckets: [0, 0.15],
			expected: '0-0.15'
		},
		{
			time: -100,
			buckets: [0, 0.15],
			expected: 'invalid'
		},
		{
			time: 150,
			buckets: [0, 0.15],
			expected: '0.15+'
		},
		{
			time: 151,
			buckets: [0, 0.15],
			expected: '0.15+'
		},
		{
			time: 0,
			buckets: [0, 0.15],
			expected: '0-0.15'
		}
	];

	function getModule() {
		return modules['ext.wikia.adEngine.utils.timeBuckets']();
	}

	testCases.forEach(function(testCase) {
		it('Time is applied to correct bucket; time: ' + testCase.time, function () {
			var module = getModule();

			expect(module.getTimeBucket(testCase.buckets, testCase.time)).toBe(testCase.expected);
		});
	})

});
