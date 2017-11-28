/*global define*/
define('ext.wikia.adEngine.utils.mutation', [
], function () {
	'use strict';

	function assign(target, varArgs) { // .length of function is 2
		if (target === null || target === undefined) { // TypeError if undefined or null
			throw new TypeError('Cannot convert undefined or null to object');
		}

		var to = Object(target);

		for (var index = 1; index < arguments.length; index++) {
			var nextSource = arguments[index];

			if (nextSource !== null || nextSource !== undefined) { // Skip over if undefined or null
				for (var nextKey in nextSource) {
					// Avoid bugs when hasOwnProperty is shadowed
					if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) {
						to[nextKey] = nextSource[nextKey];
					}
				}
			}
		}

		return to;
	}

	return {
		assign: assign
	};
});
