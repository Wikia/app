require([
	'wikia.window',
	'wikia.cookies',
], function (window, cookie) {
	'use strict';

	if (cookie.get('cookiesync_done') === null && cookie.get('tracking-opt-in-status') !== null) {
		var iframe = window.document.createElement('iframe');
		iframe.src = mw.config.get('wgCookieSyncerApiUrl');;
		iframe.classList.add("cookie-syncer-module-iframe");
		window.document.body.appendChild(iframe);
		}
});
