define('AuthModal', ['jquery', 'wikia.window'], function ($, window) {
	'use strict';

	var modal,
		$blackout,
		isOpen,
		track;

	function open (successAuthCallback) {
		if (isOpen) {
			close();
		}
		$('.WikiaSiteWrapper').append(
			'<div class="auth-blackout blackout visible"><div class="auth-modal loading">' +
				'<a class="close" href="#"></div></div>'
		);
		isOpen = true;
		$blackout = $('.auth-blackout');
		modal = $blackout.find('.auth-modal')[0];
		$('.auth-blackout, .auth-modal .close').click(close);

		track = getTrackingFunction();
		track({
			action: Wikia.Tracker.ACTIONS.OPEN,
			label: 'username-login-modal'
		});

		$(window.document).keyup(onKeyUp);
		window.addEventListener("message", function (event) {
			if (event.data.isUserAuthorized && typeof successAuthCallback === 'function') {
				successAuthCallback();
			}
		}, false);
	}

	function getTrackingFunction () {
		if (track) {
			return track;
		}
		return track = Wikia.Tracker.buildTrackingFunction({
			category: 'user-login-desktop-modal',
			trackingMethod: 'analytics'
		});
	}

	function onKeyUp (event) {
		if (event.keyCode === 27) {
			close();
		}
	}

	function close (event) {
		if (event) {
			event.preventDefault();
		}

		if (modal) {
			track({
				action: Wikia.Tracker.ACTIONS.CLOSE,
				label: 'username-login-modal'
			});
			$blackout.remove();
			isOpen = false;
		}
	}

	function onPageLoaded () {
		if (modal) {
			$(modal).removeClass('loading');
		}
	}

	function loadPage (url, onPageLoadedCallback) {
		var authIframe = window.document.createElement('iframe');
		authIframe.src = url + '&modal=1';
		authIframe.onload = function () {
			if (typeof onPageLoadedCallback === 'function') {
				onPageLoadedCallback();
			}
		};
		modal.appendChild(authIframe);

	};

	return {
		load: function (url, successAuthCallback) {

			if (typeof successAuthCallback !== 'function') {
				successAuthCallback = Function.pototype;
			}

			open(successAuthCallback);
			loadPage(url, onPageLoaded);
		},
		close: close
	};
});
