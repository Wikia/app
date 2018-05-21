/*global describe, expect, it, modules*/
describe('ext.wikia.adEngine.ml.dataSourceFactory', function () {
	'use strict';

	function getModule() {
		return modules['ext.wikia.adEngine.ml.dataSourceFactory'](
			{
				parse: function () {
					return 'parsed data';
				}
			}
		);
	}

	it('Create data source with proper interface', function () {
		var dataSource = getModule().create({
			coefficients: [ 0.5 ],
			features: [ 1 ],
			intercept: -0.1
		});

		expect(dataSource.coefficients.length).toBe(1);
		expect(dataSource.features.length).toBe(1);
		expect(typeof(dataSource.intercept)).toBe('number');
		expect(typeof(dataSource.getData)).toBe('function');
	});

	it('Throw exception when data source has missing field', function () {
		expect(function () {
			getModule().create({});
		}).toThrowError('Missing coefficients in data source definition.');
	});
});
