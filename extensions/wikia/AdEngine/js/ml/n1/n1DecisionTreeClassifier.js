/*global define*/
define('ext.wikia.adEngine.ml.n1.n1DecisionTreeClassifier', [
	'ext.wikia.adEngine.ml.n1.n1DecisionTreeClassifierInputParser',
	'ext.wikia.adEngine.ml.modelFactory',
	'ext.wikia.adEngine.ml.model.decisionTreeClassifier'
], function (inputParser, modelFactory, decisionTreeClassifier) {
	'use strict';

	var dtc = decisionTreeClassifier.create('n1dtc'),
		modelData = {
			inputParser: inputParser,
			model: dtc,
			name: 'n1dtc',
			wgCountriesVariable: 'wgAdDriverN1DecisionTreeClassifierRabbitCountries',
			enabled: false
		};

	dtc.loadParameters(function () {
		modelData.enabled = true;
	});

	return modelFactory.create(modelData);
});
