/*global define*/
define('ext.wikia.adEngine.ml.modelFactory', [
	'ext.wikia.adEngine.adContext',
	'wikia.geo',
	'wikia.instantGlobals'
], function (adContext, geo, instantGlobals) {
	'use strict';

	var requiredData = [
		'dataSource',
		'model',
		'name',
		'enabled'
	];

	function validateModel(modelData) {
		requiredData.forEach(function (key) {
			if (typeof modelData[key] === 'undefined') {
				throw new Error('Missing ' + key + ' in model definition.');
			}
		});
	}

	function create(modelData) {
		validateModel(modelData);

		var predictedValue = null;

		adContext.addCallback(function () {
			predictedValue = null;
		});

		return {
			getResult: function () {
				return this.getName() + '_' + this.predict();
			},

			getName: function () {
				return modelData.name;
			},

			isEnabled: function () {
				var isEnabled = modelData.enabled,
					isGeoEnabled = !modelData.wgCountriesVariable ||
					geo.isProperGeo(instantGlobals[modelData.wgCountriesVariable]);

				if (typeof modelData.enabled === 'function') {
					isEnabled = modelData.enabled();
				}

				return isEnabled && isGeoEnabled;
			},

			predict: function () {
				if (predictedValue === null || !modelData.cachePrediction) {
					var data = modelData.dataSource.getData();

					predictedValue = modelData.model.predict(data);
				}

				return predictedValue;
			}
		};
	}

	return {
		create: create
	};
});
