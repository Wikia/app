/*global define, require*/
define('ext.wikia.adEngine.ml.rabbit', [
	require.optional('ext.wikia.adEngine.ml.fmr.fmrLogisticRegression'),
	require.optional('ext.wikia.adEngine.ml.fmr.fmrPassiveAggressiveClassifier'),
	require.optional('ext.wikia.adEngine.ml.n1.n1DecisionTreeClassifier'),
	require.optional('ext.wikia.adEngine.ml.n1.n1LogisticRegression'),
	require.optional('ext.wikia.adEngine.ml.n1.n1mLogisticRegression'),
	require.optional('ext.wikia.adEngine.ml.outstream.outstreamLogisticRegression')
], function (
	fmrLr,
	fmrPac,
	n1dtc,
	n1Lr,
	n1mLr,
	outstreamLr
) {
	'use strict';

	var models = [
		fmrLr,
		fmrPac,
		n1dtc,
		n1Lr,
		n1mLr,
		outstreamLr
	];

	function getResults(allowedModels) {
		allowedModels = allowedModels || [];

		var results = [];

		models.forEach(function (model) {
			if (model && model.isEnabled()) {
				if (allowedModels.length > 0 && allowedModels.indexOf(model.getName()) === -1) {
					return;
				}

				results.push(model.getResult());
			}
		});

		return results;
	}

	function getSerializedResults() {
		return getResults().join(';');
	}

	return {
		getResults: getResults,
		getSerializedResults: getSerializedResults
	};
});
