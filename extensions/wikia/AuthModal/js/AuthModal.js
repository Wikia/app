define('AuthModal', ['jquery', 'AuthComponent', 'wikia.document'], function ($, AuthComponent) {
	'use strict';

	var modal,
		$blackout;

	function open () {
		$('.WikiaSiteWrapper').append(
			'<div class="auth-blackout"><div class="auth-modal"><a class="close"></div></div>'
		);
		$blackout = $('.auth-blackout');
		modal = $blackout.find('.auth-modal')[0];
		$('.auth-blackout, .auth-modal .close').click(close);
	}

	function close () {
		if (modal) {
			$blackout.remove();
		}
	}

	return {
		login: function () {
			open();
			new AuthComponent(modal).login();
		},
		register: function () {
			open();
			new AuthComponent(modal).register();
		},
		facebookConnect: function () {
			open();
			new AuthComponent(modal).facebookConnect();
		},
		facebookRegister: function () {
			open();
			new AuthComponent(modal).facebookRegister();
		}
	};
});
