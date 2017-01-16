/*global define*/
// TODO ADEN-4530 replace usages with wikia.domCalculator
define('ext.wikia.adEngine.utils.domCalculator', [
], function () {
	'use strict';

	function getTopOffset(el) {
		var topPos = 0;
		for (; el !== null; el = el.offsetParent) {
			topPos += el.offsetTop;
		}

		return topPos;
	}

	return {
		getTopOffset: getTopOffset
	};
});
