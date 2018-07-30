/*global define*/
define('ext.wikia.adEngine.ml.modelFactory', [
	'ext.wikia.adEngine.adContext',
	'wikia.querystring'
], function (adContext, Querystring) {
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
		var qs = new Querystring();
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
					isGeoEnabled = !modelData.wgCountriesVariable || adContext.isEnabled(modelData.wgCountriesVariable);

				if (typeof modelData.enabled === 'function') {
					isEnabled = modelData.enabled();
				}

				return isEnabled && isGeoEnabled;
			},

			buildModelForcedKey: function (modelName) {
				return 'rabbits.' + modelName + 'Forced';
			},

			predict: function () {
				var key = this.buildModelForcedKey(modelData.name);
				if (qs.getVal(key, undefined) !== undefined) {
					return parseInt(qs.getVal(key), 10);
				}

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
