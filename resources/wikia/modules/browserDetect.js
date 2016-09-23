define('wikia.browserDetect', ['wikia.window'], function (win) {
	'use strict';

	var appName = win.navigator.appName,
		userAgent = win.navigator.userAgent;

	/**
	 * Check if the browser is mobile - tablet or phone
	 * @returns {boolean}
     */
	function isMobile() {
		return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(userAgent);
	}

	/**
	 * Checks if the browser is IE
	 * @returns {boolean}
	 */

	function isIE() {
		var bool = false;
		if (appName === 'Microsoft Internet Explorer' || // IE <= 10
			(appName === 'Netscape' && userAgent.indexOf('Trident/') !== -1)) { // IE 11
			bool = true;
		}

		return bool;
	}

	/**
	 * Checks if the browser is Firefox
	 * @returns {Boolean}
	 */
	function isFirefox() {
		return userAgent.toLowerCase().indexOf('firefox') > -1;
	}

	/**
	 * Checks if the site is opened on iPad
	 * @returns {boolean}
	 */

	function isIPad() {
		var bool = false;
		if (userAgent.match(/iPad/i) !== null) {
			bool = true;
		}

		return bool;
	}

	/**
	 * Checks if position fixed is supported when keyboard appears.
	 * Issue is occurring in Safari 6 and 7 on iPads.
	 * @returns {boolean}
	 */
	function isIOS7orLower() {
		return !!userAgent.match(/iPad.+OS.[6,7].\d.+like.Mac.OS.+Safari/i);
	}

	function isAndroid() {
		return userAgent.toLowerCase().indexOf('android') > -1;
	}

	/**
	 * Public API
	 */

	return {
		isIE: isIE,
		isFirefox: isFirefox,
		isIPad: isIPad,
		isIOS7orLower: isIOS7orLower,
		isAndroid: isAndroid,
		isMobile: isMobile
	};
});
