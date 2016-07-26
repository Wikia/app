describe('wikia.maps.utils', function () {
	'use strict';

	var utilsModule = modules['wikia.maps.utils'](jQuery, {}, {}, {}, {}, {}, {});

	it('registers AMD module', function () {
		expect(typeof utilsModule).toBe('object');

		expect(typeof utilsModule.inArray).toBe('function');
	});

	it('triggers page refresh if requested in onBeforeClose', function () {
		spyOn(utilsModule, 'onBeforeCloseModal');
		utilsModule.onBeforeCloseModal(true);
		expect(utilsModule.refreshIfAfterForceLogin);
	});

	it('checks if a key is present in an array', function () {
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
			}
		];

		testData.forEach(function (testCase) {
			var output = utilsModule.inArray(testCase.input.array, testCase.input.key);

			expect(output).toEqual(testCase.expectedOutput);
		});
	});

	it('checks if there is no error if file is submitted', function () {
		var inputElementStub = {
			files: ['a-stub-file']
		};
		expect(function () {
			utilsModule.getFormDataForFileUpload(inputElementStub, 'just-for-test');
		}).not.toThrow(new Error('Could not find the file'));
	});

	it('checks if an error is thrown where there is no file', function () {
		var inputElementStub = {
			files: []
		};
		expect(function () {
			utilsModule.getFormDataForFileUpload(inputElementStub, 'just-for-test');
		}).toThrow(new Error('Could not find the file'));
	});

	it('checks if an error is thrown where there is no files array', function () {
		var inputElementStub = {
			files: []
		};
		expect(function () {
			utilsModule.getFormDataForFileUpload(inputElementStub, 'just-for-test');
		}).toThrow(new Error('Could not find the file'));
	});
});
