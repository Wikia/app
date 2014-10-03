describe('wikia.maps.utils', function () {
	'use strict';

	var utilsModule = modules['wikia.maps.utils'](jQuery, {}, {}, {}, {}, {}, {});

	it('registers AMD module', function() {
		expect(typeof utilsModule).toBe('object');

		expect(typeof utilsModule.inArray).toBe('function');
	});

	it('checks if a key is present in an array', function() {
		var testData = [
			{
				input: {
					array: [1, 2, 3],
					key: 1
				},
				expectedOutput: true
			},
			{
				input: {
					array: [1, 2, 3],
					key: 4
				},
				expectedOutput: false
			}, {
				input: {
					array: [],
					key: 1
				},
				expectedOutput: false
			},
			{
				input: {
					array: null,
					key: 1
				},
				expectedOutput: false
			},
		];

		testData.forEach(function (testCase) {
			var output = utilsModule.inArray(testCase.input.array, testCase.input.key);

			expect(output).toEqual(testCase.expectedOutput);
		});
	});
});
