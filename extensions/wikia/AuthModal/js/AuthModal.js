(function ($, window) {
	'use strict';

	var authPopUpWindow,
		closeTrackTimeoutId,
		popUpWindowHeight = 670,
		popUpWindowMaxWidth = 768,
		popUpName = 'WikiaAuthWindow',
		track = getTrackingFunction();

	function initPostMessageListener(onAuthSuccess) {
		$(window).on('message.authPopUpWindow', function (event) {
			var e = event.originalEvent;

			if (!e.data) {
				return;
			}

			if (e.data.isUserAuthorized) {
				close();
				if (typeof onAuthSuccess === 'function') {
					onAuthSuccess();
				}
			}

			if (e.data.beforeunload && !closeTrackTimeoutId) {
				// to avoid tracking 'close' action whenever the window is reloaded;
				closeTrackTimeoutId = setTimeout(function () {
					var trackParams;

					if (authPopUpWindow && !authPopUpWindow.closed) {
						return;
					}

					closeTrackTimeoutId = null;
					trackParams = {
						action: Wikia.Tracker.ACTIONS.CLOSE,
						label: 'username-login-modal'
					};
					if (e.data.forceLogin) {
						trackParams.category = 'force-login-modal';
					}
					track(trackParams);
				}, 1000);
			}

		});
	}

	function close(event) {
		if (event) {
			event.preventDefault();
		}
		if (authPopUpWindow) {
			authPopUpWindow.close();
		}
		$(window).off('.authPopUpWindow');
	}

	function buildPopUpUrl(url, additionalParams) {
		var defaultQueryParams = {
				modal: 1,
				forceLogin: 0
			};

		return url + (url.indexOf('?') === -1 ? '?' : '&') +
			$.param($.extend({}, defaultQueryParams, additionalParams));
	}

	function getPopUpWindowSpecs() {
		var pageWidth = window.innerWidth,
			popUpWindowWidth = pageWidth < popUpWindowMaxWidth ? pageWidth : popUpWindowMaxWidth,
			popUpWindowLeft = window.screenX + (pageWidth / 2) - (popUpWindowWidth / 2),
			popUpWindowTop = window.screenY + (window.innerHeight / 2) - (popUpWindowHeight / 2);

		return 'width=' + popUpWindowWidth + ',height=' + popUpWindowHeight + ',top=' + popUpWindowTop + ',left=' + popUpWindowLeft;
	}

	function getTrackingFunction() {
		if (track) {
			return track;
		}
		track = Wikia.Tracker.buildTrackingFunction({
			category: 'user-login-desktop-modal',
			trackingMethod: 'analytics'
		});

		return track;
	}

	function loadPopUpPage(url, forceLogin) {
		var src = buildPopUpUrl(url, {'forceLogin': (forceLogin ? 1 : 0)});

		authPopUpWindow = window.open(src, popUpName, getPopUpWindowSpecs());

		if (!authPopUpWindow || authPopUpWindow.closed) {
			window.location = url;
		}
	}

	window.wikiaAuthModal = {
		/**
		 * @desc launches the new auth modal if wgEnableNewAuthModal is set to true. If not, then the old UserLoginModal
		 * is loaded.
		 * @param {object} params:
		 * @param {string} url - url for the page we want to load in the modal
		 * @param {string} origin - used for tracking the source of force login modal
		 * @param {function} onAuthSuccess - callback function to be called after login
		 * @param {boolean} forceLogin - the window is opened from regular login button - not force login
		 */
		load: function (params) {
			var trackParams = {
				action: Wikia.Tracker.ACTIONS.OPEN,
				label: 'from-' + params.origin
			};

			if (typeof params.onAuthSuccess !== 'function') {
				params.onAuthSuccess = function () {
					window.location.reload();
				};
			}

			if (!params.origin) {
				params.origin = 'no-origin-provided';
			}

			if (window.wgEnableNewAuthModal) {
				if (params.forceLogin) {
					trackParams.category = 'force-login-modal';

					// for now we have only register-page loaded in auth pop-up window
					trackParams.label = 'register-page-from-' + params.origin;
				}

				if (!params.url) {
					params.url = '/register?redirect=' + encodeURIComponent(window.location.href);
				}

				initPostMessageListener(params.onAuthSuccess);

				track(trackParams);

				loadPopUpPage(params.url, params.forceLogin);

			} else {
				window.UserLoginModal.show({
					origin: params.origin,
					callback: params.onAuthSuccess
				});
			}
		},

		close: close
	};
})($, window);
