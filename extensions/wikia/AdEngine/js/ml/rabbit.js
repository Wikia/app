/*global define, require*/
define('ext.wikia.adEngine.ml.rabbit', [
	require.optional('ext.wikia.adEngine.ml.fmr.fmrLogisticRegression'),
	require.optional('ext.wikia.adEngine.ml.fmr.fmrPassiveAggressiveClassifier')
], function (fmrLr, fmrPac) {
	'use strict';

	var models = [
		fmrLr,
		fmrPac
	];

	function getSerializedResults() {
		var results = [];

		models.forEach(function (model) {
			if (model && model.isEnabled()) {
				results.push(model.getResult());
			}
		});

		return results.join(';');
	}

	return {
		getSerializedResults: getSerializedResults
	};
});
