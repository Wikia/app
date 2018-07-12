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

	/**
	 * Get predictions for all models which are enabled and their name
	 * matches one of allowedModelsNames values.
	 */
	function getPredictions(allowedModelsNames) {
		var results = [];

		allowedModelsNames = allowedModelsNames || [];

		models.forEach(function (model) {
			if (model && model.isEnabled() && allowedModelsNames.indexOf(model.getName()) !== -1) {
				results.push(model.predict());
			}
		});

		return results;
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
		getPredictions: getPredictions,
		getAllSerializedResults: getAllSerializedResults
	};
});
