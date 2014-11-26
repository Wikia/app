describe('dropdownNavigation utils', function () {
	'use strict';

	var utils = modules['wikia.dropdownNavigation.utils']();

	it('throws error when params validation fail', function () {
		var cases = [
			{
				sections: [],
				trigger: '#trigger',
				errorMessage: '"sections" param must be non empty array'
			},
			{
				trigger: '#trigger',
				errorMessage: '"sections" param must be non empty array'
			},
			{
				sections: [1],
				errorMessage: '"trigger" param must be a valid jQuery selector'
			},
			{
				sections: [1],
				trigger: '',
				errorMessage: '"trigger" param must be a valid jQuery selector'
			}
		];

		cases.forEach(function (params) {
			expect(function () {
				return utils.validateParams(params);
			}).toThrow(params.errorMessage);
		});
	});

	it('create subsection data based on sections children', function () {
		var cases = [
			{
				input: {
					id: 1,
					sections: [
						{
							sections: []
						}
					]
				},
				output: {
					id: 1,
					sections: [
						{
							sections: []
						}
					],
					subsections: []
				}
			},
			{
				input: {
					id: 2,
					sections: [
						{
							sections: []
						},
						{
							sections: [1, 2, 3]
						}
					]
				},
				output: {
					id: 2,
					sections: [
						{
							sections: []
						},
						{
							referenceId: '2dropdownSection-1',
							sections: [1, 2, 3]
						}
					],
					subsections: [
						{
							referenceId: '2dropdownSection-1',
							sections: [1, 2, 3]
						}
					]
				}
			},
			{
				input: {
					id: 3,
					sections: [
						{
							sections: []
						},
						{
							referenceId: '3dropdownSection-1',
							sections: [1, 2, 3]
						},
						{
							referenceId: '3dropdownSection-2',
							sections: [4, 5, 6]
						},
						{
							sections: []
						}
					]
				},
				output: {
					id: 3,
					sections: [
						{
							sections: []
						},
						{
							referenceId: '3dropdownSection-1',
							sections: [1, 2, 3]
						},
						{
							referenceId: '3dropdownSection-2',
							sections: [4, 5, 6]
						},
						{
							sections: []
						}
					],
					subsections: [
						{
							referenceId: '3dropdownSection-1',
							sections: [1, 2, 3]
						},
						{
							referenceId: '3dropdownSection-2',
							sections: [4, 5, 6]
						}
					]
				}
			}
		];

		cases.forEach(function (data) {
			expect(utils.createSubsectionData(data.input)).toEqual(data.output);
		});

	});
});
