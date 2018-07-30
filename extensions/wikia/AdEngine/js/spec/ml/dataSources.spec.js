/*global describe, expect, it, modules*/
describe('ext.wikia.adEngine.ml.dataSources', function () {
	'use strict';

	var dataSources = [
			'ext.wikia.adEngine.ml.ctp.queenDesktopDataSource',
			'ext.wikia.adEngine.ml.ctp.ctpMobileDataSource'
		],
		mocks = {
			dataSourceFactory: {
				create: function (dataSource) {
					return dataSource;
				}
			}
		};

	dataSources.forEach(function (moduleName) {
		it('Check whether ' + moduleName + ' has correct number of values and features', function () {
			var dataSource = modules[moduleName](mocks.dataSourceFactory);

			expect(dataSource.features.length).toEqual(dataSource.coefficients.length);
			expect(!isNaN(parseFloat(dataSource.intercept)) && isFinite(dataSource.intercept)).toBeTruthy();
		});
	});
});
