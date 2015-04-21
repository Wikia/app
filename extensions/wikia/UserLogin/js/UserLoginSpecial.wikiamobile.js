require(['jquery', 'wikia.window', 'wikia.loader', 'toast'], function ($, window, loader, toast) {
	'use strict';

	function loadFacebookLoginScripts() {
		loader({
			type: loader.LIBRARY,
			resources: 'facebook'
		}, {
			type: loader.MULTI,
			resources: {
				messages: 'fblogin',
				scripts: 'userlogin_facebook_js_wikiamobile',
				params: {
					useskin: window.skin
				}
			}
		}).done(function (res) {
				loader.processScript(res.scripts);
			}
		);
	}

	function init() {
		var msgBox = document.getElementById('wkLgnMsg'),
			msg = msgBox && msgBox.innerText;

		if (msg) {
			toast.show(msg);
		}

		loadFacebookLoginScripts();
	}

	$(init);
});
