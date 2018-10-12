require([
	'wikia.window',
	'wikia.cookies',
], function (window, cookie) {
	'use strict';

	var isSafari = function () {
		var ua = navigator.userAgent.toLowerCase();
		return ua.indexOf('safari') !== -1 && ua.indexOf('chrome') === -1;
	};

	if (cookie.get('autologin_done') === '1' && mw.user.anonymous() && isSafari()) {
		var iframe = window.document.createElement('iframe');
		iframe.src = mw.config.get('wgPassiveAutologinUrl');
		iframe.classList.add("auto-login-module-iframe");
		window.document.body.appendChild(iframe);

		window.addEventListener('message', function (event) {
			if (event.data === "is_authed") {
				window.location.reload();
			}
		}, false);
	}
});
