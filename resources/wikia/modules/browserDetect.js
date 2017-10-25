/*global define*/
define('wikia.browserDetect', ['wikia.window'], function (win) {
	'use strict';

	var appName = win.navigator.appName,
		userAgent = win.navigator.userAgent,
		browser = null,
		operatingSystem = null;

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
	 * Check if the browser is Edge
	 * @returns {boolean}
	 */
	function isEdge() {
		return userAgent.indexOf('Edge') !== -1;
	}

	/**
	 * Checks if the browser is Firefox
	 * @returns {Boolean}
	 */
	function isFirefox() {
		return userAgent.toLowerCase().indexOf('firefox') > -1;
	}

	/**
	 * Checks if the browser is Chrome
	 * @returns {Boolean}
	 */
	function isChrome() {
		return userAgent.toLowerCase().indexOf('chrome') > -1;
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

	function getOS() {
		if (null !== operatingSystem) {
			return operatingSystem;
		}

		operatingSystem = 'unknown';
		if (userAgent.indexOf('Win') !== -1) {
			operatingSystem = 'Windows';
		}
		if (userAgent.indexOf('Mac') !== -1) {
			operatingSystem = 'OSX';
		}
		if (userAgent.indexOf('Linux') !== -1) {
			operatingSystem = 'Linux';
		}
		if (userAgent.indexOf('Android') !== -1) {
			operatingSystem = 'Android';
		}
		if (userAgent.indexOf('like Mac') !== -1) {
			operatingSystem = 'iOS';
		}

		return operatingSystem;
	}

	function getBrowser() {
		if (null !== browser) {
			return browser;
		}

		var appVersion = win.navigator.appVersion,
			temp,
			matches = userAgent.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];

		if (/trident/i.test(matches[1])) {
			temp = /\brv[ :]+(\d+)/g.exec(userAgent) || [];
			browser = 'IE ' + (temp[1] || '');
			return browser;
		}
		if (matches[1] === 'Chrome'){
			temp= userAgent.match(/\b(OPR|Edge)\/(\d+)/);
			if (temp !== null) {
				browser = temp.slice(1).join(' ').replace('OPR', 'Opera');
				return browser;
			}
		}

		matches = matches[2] ? [matches[1], matches[2]] : [appName, appVersion, '-?'];
		temp = userAgent.match(/version\/(\d+)/i);
		if (temp !== null) {
			matches.splice(1, 1, temp[1]);
		}
		browser = matches.join(' ');

		return browser;
	}

	function getBrowserVersion() {
		var browserStringParts = getBrowser().split(' ');

		return parseInt(browserStringParts[1], 10);
	}

	/**
	 * Public API
	 */
	return {
		getBrowser: getBrowser,
		getBrowserVersion: getBrowserVersion,
		getOS: getOS,
		isChrome: isChrome,
		isIE: isIE,
		isFirefox: isFirefox,
		isIPad: isIPad,
		isIOS7orLower: isIOS7orLower,
		isAndroid: isAndroid,
		isMobile: isMobile,
		isEdge: isEdge
	};
});
