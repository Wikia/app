define( 'wikia.browserDetect', function() {
	'use strict';

	var appName = navigator.appName,
		userAgent = navigator.userAgent;

	function isIE() {
		var bool = false;
		if ( appName === 'Microsoft Internet Explorer' || // IE <= 10
			( appName === 'Netscape' && userAgent.indexOf( 'Trident/' ) !== -1 ) ) { // IE 11
			bool = true;
		}

		return bool;
	}

	return {
		isIE: isIE
	};
} );