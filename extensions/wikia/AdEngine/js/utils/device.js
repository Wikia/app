/* global define */
define('ext.wikia.adEngine.utils.device', [
	'wikia.browserDetect'
], function (browserDetect) {
	'use strict';

	var result = '';

	function getDevice(params) {
		if (params.skin === 'oasis') {
			result = browserDetect.isMobile() ? 'tablet' : 'desktop';
		} else if (params.skin === 'mercury' || params.skin === 'mobile-wiki') {
			result = 'smartphone';
		}

		return result;
	}

	function getDeviceSpecial(params) {
		result = 'unknown';

		if (params.s2 === 'special') {
			return 'unknown-specialpage';
		}

		return getDevice(params);
	}

	return {
		getDevice: getDevice,
		getDeviceSpecial: getDeviceSpecial
	};
});
