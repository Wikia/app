/*global define*/
define('ext.wikia.adEngine.uapContext', [
], function () {
	'use strict';

	var context = {};

	function setUapId(uap) {
		context.uapId = uap;
	}

	function getUapId() {
		return context.uapId;
	}

	function isUapLoaded() {
		return !!context.uapId;
	}

	function reset() {
		context = {};
	}

	return {
		getUapId: getUapId,
		isUapLoaded: isUapLoaded,
		reset: reset,
		setUapId: setUapId
	};
});
