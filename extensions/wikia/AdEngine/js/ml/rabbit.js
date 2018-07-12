/*global define, require*/
define('ext.wikia.adEngine.ml.rabbit', [
	require.optional('ext.wikia.adEngine.ml.ctp.ctpDesktop'),
	require.optional('ext.wikia.adEngine.ml.ctp.ctpMobile'),
	require.optional('ext.wikia.adEngine.ml.ctp.queenDesktop'),
	require.optional('ext.wikia.adEngine.ml.n1.n1DecisionTreeClassifier'),
	require.optional('ext.wikia.adEngine.ml.n1.n1LogisticRegression'),
	require.optional('ext.wikia.adEngine.ml.n1.n1mLogisticRegression'),
	require.optional('ext.wikia.adEngine.ml.nivens.mobileNivensLogisticRegression')
], function (
	ctpDesktop,
	ctpMobile,
	queenDesktop,
	n1dtc,
	n1Lr,
	n1mLr,
	mobileNivens
) {
	'use strict';

	var models = [
		ctpDesktop,
		ctpMobile,
		queenDesktop,
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

	function getEnabledModels() {
		return models.filter(
			function (model) { return model && model.isEnabled(); }
		);
	}

	/**
	 * Get prediction for model with name equal to modelName argument.
	 */
	function getPrediction(modelName) {
		return getEnabledModels()
			// Oh God I miss arrow functions
			.filter(function(model) { return model.getName() === modelName; })
			.map(function(model) { return model.predict(); })[0];
	}

	function getResults(allowedModelsNames) {
		var results = [];

		allowedModelsNames = allowedModelsNames || [];

		models.forEach(function (model) {
			if (model && model.isEnabled() && allowedModelsNames.indexOf(model.getName()) !== -1) {
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
		getPrediction: getPrediction,
		getAllSerializedResults: getAllSerializedResults
	};
});
