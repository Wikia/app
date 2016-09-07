define('ext.wikia.adEngine.utils.env', [
	'wikia.window'
], function (win) {
	'use strict';

	function isDevEnvironment() {
		return /.+wikia-dev\.com$/.test(win.location.host);
	}

	return {
		isDevEnvironment: isDevEnvironment
	}
});
