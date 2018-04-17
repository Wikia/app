/*global define*/
define('ext.wikia.adEngine.ml.n1.n1DecisionTreeClassifier', [
	'ext.wikia.adEngine.ml.n1.n1DecisionTreeClassifierInputParser',
	'ext.wikia.adEngine.ml.modelFactory',
	'ext.wikia.adEngine.ml.model.decisionTreeClassifier',
	'wikia.geo',
	'wikia.instantGlobals'
], function (inputParser, modelFactory, decisionTreeClassifier, geo, instantGlobals) {
	'use strict';

	var dtc = decisionTreeClassifier.create('n1dtc'),
		modelData = {
			inputParser: inputParser,
			model: dtc,
			name: 'n1dtc',
			wgCountriesVariable: 'wgAdDriverN1DecisionTreeClassifierRabbitCountries',
			enabled: false,
			cachePrediction: true
		};

	if (geo.isProperGeo(instantGlobals[modelData.wgCountriesVariable])) {
		dtc.loadParameters(function () {
			modelData.enabled = true;
		});
	}

	return modelFactory.create(modelData);
});
