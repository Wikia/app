/*global define*/
define('ext.wikia.adEngine.uapContext', [
	'wikia.window',
], function (win) {
	'use strict';

	win.ads = win.ads || {};
	win.ads.uapContext = win.ads.uapContext || {};

	function setUapId(bfabLineItemId) {
		win.ads.uapContext.uap = bfabLineItemId;
	}

	function getUapId() {
		return win.ads.uapContext.uap;
	}

	return {
		setUapId: setUapId,
		getUapId: getUapId
	};
});
