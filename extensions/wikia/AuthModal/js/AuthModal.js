define('AuthModal', ['jquery', 'wikia.window'], function ($, window) {
	'use strict';

	var popUpWindowHeight = 670,
		popUpWindowMaxWidth = 768,
		popUpWindowParam = 'modal=1',
		authPopUpWindow,
		track;

	function open (onAuthSuccess) {
		track = getTrackingFunction();
		track({
			action: Wikia.Tracker.ACTIONS.OPEN,
			label: 'username-login-modal'
		});

		$(window).on('message.authPopUpWindow', function (event) {
			var e = event.originalEvent;

			if (typeof e.data !== 'undefined' && e.data.isUserAuthorized) {
				close();
				if (typeof onAuthSuccess === 'function') {
					onAuthSuccess();
				}
			}
		});
	}

	function close (event) {
		if (event) {
			event.preventDefault();
		}
		if (authPopUpWindow) {
			authPopUpWindow.close();
		}
		$(window).off('.authPopUpWindow');
	}

	function getPopUpWindowSpecs() {
		var pageWidth = window.innerWidth,
			popUpWindowWidth = pageWidth < popUpWindowMaxWidth ? pageWidth : popUpWindowMaxWidth,
			popUpWindowLeft = window.screenX + (pageWidth / 2) - (popUpWindowWidth / 2),
			popUpWindowTop = window.screenY + (window.innerHeight / 2) - (popUpWindowHeight / 2);

		return 'width=' + popUpWindowWidth + ',height=' + popUpWindowHeight + ',top=' + popUpWindowTop + ',left=' + popUpWindowLeft;
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

	function loadPage (url) {
		var src = url + (url.indexOf('?') === -1 ? '?' : '&') + popUpWindowParam;

		authPopUpWindow = window.open(src, '_blank', getPopUpWindowSpecs());

		if (authPopUpWindow && !authPopUpWindow.closed) {
			authPopUpWindow.onbeforeunload = function () {
				track({
					action: Wikia.Tracker.ACTIONS.CLOSE,
					label: 'username-login-modal'
				});
			};
		} else {
			window.location = url;
		}
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

				loadPage(params.url);

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
