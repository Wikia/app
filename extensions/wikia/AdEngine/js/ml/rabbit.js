/*global define, require*/
define('ext.wikia.adEngine.ml.rabbit', [
	require.optional('ext.wikia.adEngine.ml.fmr.fmrLogisticRegression'),
	require.optional('ext.wikia.adEngine.ml.fmr.fmrPassiveAggressiveClassifier'),
	require.optional('ext.wikia.adEngine.ml.n1.n1LogisticRegression'),
	require.optional('ext.wikia.adEngine.ml.n1.n1mLogisticRegression'),
	require.optional('ext.wikia.adEngine.ml.outstream.outstreamLogisticRegression')
], function (
	fmrLr,
	fmrPac,
	n1Lr,
	n1mLr,
	outstreamLr
) {
	'use strict';

	var models = [
		fmrLr,
		fmrPac,
		n1Lr,
		n1mLr,
		outstreamLr
	];

	function getSerializedResults() {
		var results = [];

		models.forEach(function (model) {
			console.log(model && model.getName(), model && model.isEnabled());
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
