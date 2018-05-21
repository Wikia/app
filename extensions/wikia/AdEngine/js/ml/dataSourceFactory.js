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
			coefficients: dataSource.coefficients,
			features: dataSource.features,
			intercept: dataSource.intercept,

			getData: function () {
				return inputParser.parse(dataSource.features);
			}
		};
	}

	return {
		create: create
	};
});
