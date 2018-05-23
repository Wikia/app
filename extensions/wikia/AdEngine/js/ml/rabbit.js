/*global define, require*/
define('ext.wikia.adEngine.ml.rabbit', [
	require.optional('ext.wikia.adEngine.ml.ctp.ctpDesktop'),
	require.optional('ext.wikia.adEngine.ml.ctp.ctpMobile'),
	require.optional('ext.wikia.adEngine.ml.n1.n1DecisionTreeClassifier'),
	require.optional('ext.wikia.adEngine.ml.n1.n1LogisticRegression'),
	require.optional('ext.wikia.adEngine.ml.n1.n1mLogisticRegression'),
	require.optional('ext.wikia.adEngine.ml.nivens.mobileNivensLogisticRegression')
], function (
	ctpDesktop,
	ctpMobile,
	n1dtc,
	n1Lr,
	n1mLr,
	mobileNivens
) {
	'use strict';

	var models = [
		ctpDesktop,
		ctpMobile,
		n1dtc,
		n1Lr,
		n1mLr,
		mobileNivens
	];

	function getModelNames() {
		return models.map(function (model) {
			if (model) {
				return model.getName();
			}
		});
	}

	function getResults(allowedModels) {
		var results = [];
		
		allowedModels = allowedModels || [];

		models.forEach(function (model) {
			if (model && model.isEnabled() && allowedModels.indexOf(model.getName()) !== -1) {
				results.push(model.getResult());
			}
		});

		return results;
	}

	function getAllSerializedResults() {
		var allowedModels = getModelNames();

		return getResults(allowedModels).join(';');
	}

	return {
		getResults: getResults,
		getAllSerializedResults: getAllSerializedResults
	};
});
