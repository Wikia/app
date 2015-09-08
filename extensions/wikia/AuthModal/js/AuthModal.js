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
		window.addEventListener('message', function (event) {
			if (event.data.isUserAuthorized) {
				close();
				if (typeof successAuthCallback === 'function') {
					successAuthCallback();
				}
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
		var authIframe = window.document.createElement('iframe'),
			modalParam = 'modal=1';


		authIframe.src = url + (url.indexOf('?') === -1 ? '?' : '&')  + modalParam;
		authIframe.onload = function () {
			if (typeof onPageLoadedCallback === 'function') {
				onPageLoadedCallback();
			}
		};
		modal.appendChild(authIframe);

	};

	return {
		/**
		 * @desc launches the new auth modal if wgEnableNewAuthModal is set to true. If not, then the old UserLoginModal
		 * is loaded.
		 * @param {object} params:
		 * @param {string} url - url for the page we want to load in the modal
		 * @param {string} origin - used for tracking the source of force login modal
		 * @param {function} successAuthCallback - callback function to be called after login
		 */
		load: function (params) {
			if (typeof params.successAuthCallback !== 'function') {
				params.successAuthCallback = Function.pototype;
			}

			if (window.wgEnableNewAuthModal) {
				open(params.successAuthCallback);
				loadPage(params.url, onPageLoaded);

			} else {
				window.UserLoginModal.show({
					origin: params.origin,
					callback: params.successAuthCallback
				});
			}
		},
		close: close
	};
});
