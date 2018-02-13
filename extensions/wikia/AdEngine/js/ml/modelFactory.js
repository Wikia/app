/*global define*/
define('ext.wikia.adEngine.ml.modelFactory', [
	'ext.wikia.adEngine.adContext',
	'wikia.geo',
	'wikia.instantGlobals'
], function (adContext, geo, instantGlobals) {
	'use strict';

	var requiredData = [
		'inputParser',
		'model',
		'name',
		'wgCountriesVariable',
		'enabled'
	];

	function create(modelData) {
		requiredData.forEach(function (key) {
			if (typeof modelData[key] === 'undefined') {
				throw new Error('Missing ' + key + ' in model definition.');
			}
		});

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
				return modelData.enabled && geo.isProperGeo(instantGlobals[modelData.wgCountriesVariable]);
			},

			predict: function () {
				if (predictedValue === null || !modelData.cachePrediction) {
					var data = modelData.inputParser.getData();

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
