/*global describe, expect, it, modules*/
describe('ext.wikia.adEngine.ml.modelFactory', function () {
	'use strict';

	function getModule() {
		return modules['ext.wikia.adEngine.ml.modelFactory']();
	}

	it('Create model with proper interface', function () {
		var model = getModule().create({
			inputParser: {},
			model: {},
			name: 'foo',
			wgCountriesVariable: 'bar',
			enabled: true
		});

		expect(typeof(model.getResult)).toBe('function');
		expect(typeof(model.getName)).toBe('function');
		expect(typeof(model.isEnabled)).toBe('function');
		expect(typeof(model.predict)).toBe('function');
	});

	it('Throw exception when model has missing field', function () {
		expect(function () {
			getModule().create({
				inputParser: {},
				model: {},
				wgCountriesVariable: 'bar',
				enabled: true
			});
		}).toThrowError('Missing name in model definition.');
	});
});
