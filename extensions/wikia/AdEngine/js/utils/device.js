/* global define */
define('ext.wikia.adEngine.utils.device', [
	'wikia.browserDetect'
], function (browserDetect) {
	'use strict';

	function getDevice(params) {
		if (params.skin === 'oasis') {
			return result = browserDetect.isMobile() ? 'tablet' : 'desktop';
		} else if (params.skin === 'mercury' || params.skin === 'mobile-wiki') {
			return result = 'smartphone';
		}

		return 'unknown';
	}

	return {
		getDevice: getDevice,
	};
});
