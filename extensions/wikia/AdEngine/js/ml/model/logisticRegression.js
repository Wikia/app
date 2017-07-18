/*global define*/
define('ext.wikia.adEngine.ml.model.logisticRegression', [], function () {
	'use strict';

	function create(coefficients, intercept) {
		function predict(x) {
			var i,
				result = 0;

			if (x.length !== coefficients.length) {
				throw 'Incorrect vectors';
			}

			for (i = 0; i < coefficients.length; i += 1) {
				result += x[i] * coefficients[i];
			}
			result += intercept;

			return result > 0 ? 1 : 0;
		}

		return {
			predict: predict
		};
	}

	return {
		create: create
	};
});
