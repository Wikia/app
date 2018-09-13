require([
	'wikia.window',
], function (window) {
	'use strict';

	if (window.document.cookie.indexOf('cookiesync_done') === -1 && window.document.cookie.indexOf('tracking-opt-in-status') !== -1) {
		var iframe = window.document.createElement('iframe');
		iframe.style.display = "none";
		iframe.src = mw.config.get('wgCookieSyncerApiUrl');;
		iframe.classList.add("cookie-syncer-module-iframe");
		window.document.body.appendChild(iframe);
		}
});
