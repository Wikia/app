/*global describe, expect, it, modules*/
describe('ext.wikia.adEngine.ml.modelFactory', function () {
	'use strict';

	function getModule() {
		return modules['ext.wikia.adEngine.ml.modelFactory'](
			// adContext
			{
				addCallback: function () {}
			},
			// querystring
			function () {
				this.getVal = function () { return '1'; };
			}
		);
	}

	it('Create model with proper interface', function () {
		var model = getModule().create({
			dataSource: {},
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

	it('Enabled property can be a function', function () {
		var model = getModule().create({
			dataSource: {},
			model: {},
			name: 'foo',
			enabled: function () {
				return false;
			}
		});

		expect(model.isEnabled()).toBeFalsy();
	});

	it('Throw exception when model has missing field', function () {
		expect(function () {
			getModule().create({
				dataSource: {},
				model: {},
				wgCountriesVariable: 'bar',
				enabled: true
			});
		}).toThrowError('Missing name in model definition.');
	});
});
