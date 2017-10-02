/*global define*/
define('ext.wikia.adEngine.ml.model.linear', [
	'wikia.log'
], function (log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.ml.model.linear';

	function create(coefficients, intercept) {
		function predict(x) {
			var i,
				result = 0;

			if (x.length !== coefficients.length) {
				log('Incorrect vectors', log.levels.debug, logGroup);
				return -1;
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
