/*global define*/
define('ext.wikia.adEngine.ml.modelFactory', [
	'wikia.geo',
	'wikia.instantGlobals'
], function (geo, instantGlobals) {
	'use strict';

	var requiredData = [
		'inputParser',
		'model',
		'name',
		'wgCountriesVariable'
	];

	function create(modelData) {
		requiredData.forEach(function (key) {
			if (!modelData[key]) {
				throw new Error('Missing ' + key + ' in model definition.');
			}
		});

		return {
			getResult: function () {
				return this.getName() + '_' + this.predict();
			},

			getName: function () {
				return modelData.name;
			},

			isEnabled: function () {
				return geo.isProperGeo(instantGlobals[modelData.wgCountriesVariable]);
			},

			predict: function () {
				var data = modelData.inputParser.getData();

				return modelData.model.predict(data);
			}
		};
	}

	return {
		create: create
	};
});
