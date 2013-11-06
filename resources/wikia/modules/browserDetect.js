define( 'wikia.browserDetect', function() {
	'use strict';

	var appName = navigator.appName,
		userAgent = navigator.userAgent;

	/**
	 * Checks if the browser is IE
	 * @returns {boolean}
	 */

	function isIE() {
		var bool = false;
		if ( appName === 'Microsoft Internet Explorer' || // IE <= 10
			( appName === 'Netscape' && userAgent.indexOf( 'Trident/' ) !== -1 ) ) { // IE 11
			bool = true;
		}

		return bool;
	}

	/**
	 * Public API
	 */

	return {
		isIE: isIE
	};
} );