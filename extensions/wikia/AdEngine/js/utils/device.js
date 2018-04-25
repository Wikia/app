/* global define */
define('ext.wikia.adEngine.utils.device', [
	'wikia.browserDetect'
], function (browserDetect) {
	'use strict';

	var result = 'unknown';

	function getDevice(params) {
		if (params.skin === 'oasis') {
			result = browserDetect.isMobile() ? 'tablet' : 'desktop';
		} else if (params.skin === 'mercury' || params.skin === 'mobile-wiki') {
			result = 'smartphone';
		}

		return result;
	}

	return {
		getDevice: getDevice,
	};
});
