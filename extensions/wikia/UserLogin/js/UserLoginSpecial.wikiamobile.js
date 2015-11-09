(function () {
	'use strict';

	var $ = require('jquery'),
		window = require('wikia.window'),
		loader = require('wikia.loader'),
		toast = require('toast');

	function loadFacebookLoginScripts() {
		loader({
			type: loader.LIBRARY,
			resources: 'facebook'
		}, {
			type: loader.MULTI,
			resources: {
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
})();
