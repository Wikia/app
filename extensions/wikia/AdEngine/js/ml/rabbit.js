/*global define, require*/
define('ext.wikia.adEngine.ml.rabbit', [
	'wikia.instantGlobals',
	require.optional('ext.wikia.adEngine.ml.ctp.ctpDesktop'),
	require.optional('ext.wikia.adEngine.ml.ctp.ctpMobile'),
	require.optional('ext.wikia.adEngine.ml.ctp.queenDesktop'),
	require.optional('ext.wikia.adEngine.ml.n1.n1DecisionTreeClassifier'),
	require.optional('ext.wikia.adEngine.ml.n1.n1LogisticRegression'),
	require.optional('ext.wikia.adEngine.ml.n1.n1mLogisticRegression'),
	require.optional('ext.wikia.adEngine.ml.nivens.mobileNivensLogisticRegression')
], function (
	instantGlobals,
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
	 *
	 * The prediction can be overriden by setting a URL parameter
	 * in format rabbits.{modelName}Forced=0/1.
	 *
	 * @return {number | undefined} Prediction value or undefined if model is not enabled
	 */
	function getPrediction(modelName) {
		var model = getEnabledModels()
			.filter(function(model) { return model.getName() === modelName; })[0];
		return model ? model.predict() : undefined;
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

	function getTargetingValues() {
		return getResults(instantGlobals.wgAdDriverRabbitTargetingKeyValues);
	}

	return {
		getResults: getResults,
		getPrediction: getPrediction,
		getAllSerializedResults: getAllSerializedResults,
		getTargetingValues: getTargetingValues
	};
});
