/*global define*/
define('ext.wikia.adEngine.uapContext', [
], function () {
	'use strict';

	var uapId;

	function setUapId(uap) {
		uapId = uap;
	}

	function getUapId() {
		return uapId;
	}

	return {
		getUapId: getUapId,
		setUapId: setUapId
	};
});
