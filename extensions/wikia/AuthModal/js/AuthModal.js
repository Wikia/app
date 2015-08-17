define('AuthModal', ['jquery', 'AuthComponent', 'wikia.document'], function ($, AuthComponent) {
	'use strict';

	var modal,
		$blackout,
		track;

	function open () {
		$('.WikiaSiteWrapper').append(
			'<div class="auth-blackout"><div class="auth-modal loading"><span></span><a class="close"></div></div>'
		);
		$blackout = $('.auth-blackout');
		modal = $blackout.find('.auth-modal')[0];
		$('.auth-blackout, .auth-modal .close').click(close);

		track = Wikia.Tracker.buildTrackingFunction({
			action: Wikia.Tracker.ACTIONS.CLOSE,
			category: 'user-login-desktop-modal',
			trackingMethod: 'analytics'
		});
	}

	function close () {
		if (modal) {
			track({
				label: 'username-login-modal'
			});
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
