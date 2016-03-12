define('AuthModal', ['jquery', 'wikia.window'], function ($, window) {
	'use strict';

	var authPopUp,
		modal,
		$blackout,
		isOpen,
		track;

	function open (onAuthSuccess) {
		if (isOpen) {
			close();
		}
		$('.WikiaSiteWrapper').append('<div class="auth-blackout visible"><div class="auth-modal loading"></div></div>');
		isOpen = true;
		$blackout = $('.auth-blackout');
		modal = $blackout.find('.auth-modal')[0];

		track = getTrackingFunction();
		track({
			action: Wikia.Tracker.ACTIONS.OPEN,
			label: 'username-login-modal'
		});

		$(window).on({
			'keyup.authPopUp' : onKeyUp,
			'message.authPopUp': function (event) {
				var e = event.originalEvent;

				if (typeof e.data !== 'undefined' && e.data.isUserAuthorized) {
					close();
					if (typeof onAuthSuccess === 'function') {
						onAuthSuccess();
					}
				}
			}
		});
	}

	function getTrackingFunction () {
		if (track) {
			return track;
		}
		track = Wikia.Tracker.buildTrackingFunction({
			category: 'user-login-desktop-modal',
			trackingMethod: 'analytics'
		});

		return track;
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
			authPopUp.close();

			isOpen = false;
		}
		$(window).off('.authPopUp');
	}

	function onPageLoaded () {
		if (modal) {
			$(modal).removeClass('loading');
			$blackout.remove();
		}
	}

	function loadPage (url, onPageLoaded) {
		var browserWindowWidth = window.innerWidth,
			modalParam = 'modal=1',
			popUpHeight= 670,
			popUpMaxWidth = 768,
			popUpWidth= browserWindowWidth < popUpMaxWidth ? browserWindowWidth : popUpMaxWidth,
			popUpLeft = window.screenX + (browserWindowWidth/2) - (popUpWidth/2),
			popUpTop = window.screenY + (window.innerHeight/2) - (popUpHeight/2),
			src = url + (url.indexOf('?') === -1 ? '?' : '&') + modalParam;

		authPopUp = window.open(src, '_blank','width='+popUpWidth+',height='+popUpHeight+',top='+popUpTop+',left='+popUpLeft);

		$(authPopUp).ready(function () {
			if (typeof onPageLoaded === 'function') {
				onPageLoaded();
			}
		});
	}

	return {
		/**
		 * @desc launches the new auth modal if wgEnableNewAuthModal is set to true. If not, then the old UserLoginModal
		 * is loaded.
		 * @param {object} params:
		 * @param {string} url - url for the page we want to load in the modal
		 * @param {string} origin - used for tracking the source of force login modal
		 * @param {function} onAuthSuccess - callback function to be called after login
		 */
		load: function (params) {
			if (typeof params.onAuthSuccess !== 'function') {
				params.onAuthSuccess = function () {
					window.location.reload();
				};
			}

			if (!params.origin) {
				params.origin = 'no-origin-provided';
			}

			if (window.wgEnableNewAuthModal) {
				open(params.onAuthSuccess);

				track({
					action: Wikia.Tracker.ACTIONS.OPEN,
					label: 'from-' + params.origin
				});

				loadPage(params.url, onPageLoaded);

			} else {
				window.UserLoginModal.show({
					origin: params.origin,
					callback: params.onAuthSuccess
				});
			}
		},
		close: close
	};
});
