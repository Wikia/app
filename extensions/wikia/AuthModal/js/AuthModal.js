define('AuthModal', ['jquery', 'AuthComponent', 'wikia.window'], function ($, AuthComponent, window) {
	'use strict';

	var modal,
		$blackout,
		language = window.wgContentLanguage;

	function open () {
		$('.WikiaSiteWrapper').append(
			'<div class="auth-blackout blackout visible"><div class="auth-modal loading"><a class="close"></div></div>'
		);
		$blackout = $('.auth-blackout');
		modal = $blackout.find('.auth-modal')[0];
		$('.auth-blackout, .auth-modal .close').click(close);
		$(window.document).keyup(onKeyUp);
	}

	function onKeyUp (event) {
		if (event.keyCode === 27) {
			close();
		}
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
			new AuthComponent(modal).login(onAuthComponentLoaded, language);
		},
		register: function () {
			open();
			new AuthComponent(modal).register(onAuthComponentLoaded, language);
		},
		facebookConnect: function () {
			open();
			new AuthComponent(modal).facebookConnect(onAuthComponentLoaded, language);
		},
		facebookRegister: function () {
			open();
			new AuthComponent(modal).facebookRegister(onAuthComponentLoaded, language);
		}
	};
});
