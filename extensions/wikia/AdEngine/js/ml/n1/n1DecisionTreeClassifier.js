/*global define*/
define('ext.wikia.adEngine.ml.n1.n1DecisionTreeClassifier', [
	'ext.wikia.adEngine.ml.n1.n1DecisionTreeClassifierInputParser',
	'ext.wikia.adEngine.ml.modelFactory',
	'ext.wikia.adEngine.ml.model.decisionTreeClassifier',
	'ext.wikia.adEngine.adContext'
], function (inputParser, modelFactory, decisionTreeClassifier, adContext) {
	'use strict';

	var dtc = decisionTreeClassifier.create('n1dtc'),
		modelData = {
			dataSource: inputParser,
			model: dtc,
			name: 'n1dtc',
			wgCountriesVariable: 'wgAdDriverN1DecisionTreeClassifierRabbitCountries',
			enabled: false,
			cachePrediction: true
		};

	if (adContext.isEnabled(modelData.wgCountriesVariable)) {
		dtc.loadParameters(function () {
			modelData.enabled = true;
		});
	}

	return modelFactory.create(modelData);
});
