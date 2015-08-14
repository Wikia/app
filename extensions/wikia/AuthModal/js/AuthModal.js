define('AuthModal', ['jquery', 'AuthComponent', 'wikia.document'], function ($, AuthComponent) {
	'use strict';

	var modal,
		$blackout;

	function open () {
		$('.WikiaSiteWrapper').append(
			'<div class="auth-blackout"><div class="auth-modal loading"><span></span><a class="close"></div></div>'
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

	function onAuthComponentLoaded () {
		if (modal) {
			$(modal).removeClass('loading');
		}
	}

	return {
		login: function () {
			open();
			new AuthComponent(modal).login(onAuthComponentLoaded);
		},
		register: function () {
			open();
			new AuthComponent(modal).register(onAuthComponentLoaded);
		},
		facebookConnect: function () {
			open();
			new AuthComponent(modal).facebookConnect(onAuthComponentLoaded);
		},
		facebookRegister: function () {
			open();
			new AuthComponent(modal).facebookRegister(onAuthComponentLoaded);
		}
	};
});
