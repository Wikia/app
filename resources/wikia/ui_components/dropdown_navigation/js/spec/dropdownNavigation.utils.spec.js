describe('dropdownNavigation utils', function () {
	'use strict';

	var utils = modules['wikia.dropdownNavigation']();

	/**
	 * @desc validation helper
	 * @param {Object} params
	 * @throws {Error} - when validation fail
	 */
	function validateHelper(params) {
		utils.validateParams(params);
	}

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
				trigger: '#',
				errorMessage: '"trigger" param must be a valid jQuery selector'
			}
		];

		cases.forEach(function (params) {
			expect(validateHelper).toThrow(params.errorMessage);
		});
	});
});
