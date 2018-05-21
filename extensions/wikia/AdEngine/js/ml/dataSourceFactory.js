/*global define*/
define('ext.wikia.adEngine.ml.dataSourceFactory', [
	'ext.wikia.adEngine.ml.inputParser',
], function (inputParser) {
	'use strict';

	var requiredData = [
		'coefficients',
		'features',
		'intercept'
	];

	function create(dataSource) {
		requiredData.forEach(function (key) {
			if (typeof dataSource[key] === 'undefined') {
				throw new Error('Missing ' + key + ' in data source definition.');
			}
		});

		return {
			getCoefficients: function () {
				return dataSource.coefficients;
			},

			getData: function () {
				return inputParser.parse(dataSource.features);
			},

			getIntercept: function () {
				return dataSource.intercept;
			}
		};
	}

	return {
		create: create
	};
});
