/*global describe, expect, it, modules*/
describe('ext.wikia.adEngine.ml.dataSources', function () {
	'use strict';

	var dataSources = [
			'ext.wikia.adEngine.ml.ctp.ctpDesktopDataSource'
		],
		mocks = {
			inputParser: {
				parse: function (features) {
					return features;
				}
			},
			log: function () {}
		};

	mocks.log.levels = {};

	dataSources.forEach(function (moduleName) {
		it('Check whether ' + moduleName + ' has correct number of values and features', function () {
			var dataSource = modules[moduleName](
					mocks.inputParser,
					mocks.log
				),
				intercept = dataSource.getIntercept();

			expect(dataSource.getData().length).toEqual(dataSource.getCoefficients().length);
			expect(!isNaN(parseFloat(intercept)) && isFinite(intercept)).toBeTruthy();
		});
	});
});
