/* global jQuery, mediaWiki */
(function (window, $, mw) {
	'use strict';

	var fbPreferences = (function () {

		// Instance stores a reference to the singleton
		var instance,
			$connectWrapper,
			$disconnectWrapper,
			$disconnectLink,
			$disconnectButton,
			$connectLink;

		/**
		 * Create single instance. Call after DOM is ready.
		 * We could return an object with public functions and state variables but it's not necessary ATM.
		 */
		function init() {
			// cache DOM objects
			$connectWrapper = $('#fbConnectPreferences');
			$disconnectWrapper = $('#fbDisconnectPreferences');
			$disconnectLink = $('#fbDisconnectLink').find('a');
			$disconnectButton = $('.fb-disconnect');
			$connectLink = $('.sso-login-facebook');

			$.loadFacebookSDK()
				.done(function () {
					bindEvents();
				})
				.fail(facebookError);

			return {};
		}

		/**
		 * Toggle between the connected and disconnected views of the preferences panel
		 */
		function toggle() {
			$connectWrapper
				.add($disconnectWrapper)
				.toggleClass('hidden');
		}

		/**
		 * Called upon successful facebook login
		 */
		function loginCallback() {
			$.nirvana.sendRequest({
				controller: 'FacebookClient',
				method: 'connectLoggedInUser',
				format: 'json',
				callback: function (data) {
					if (data.status === 'ok') {

						new window.BannerNotification()
							.setContent($.msg('fbconnect-preferences-connected'))
							.setType('confirm')
							.show();

						window.Wikia.Tracker.track({
							category: 'user-sign-up',
							trackingMethod: 'both',
							action: window.Wikia.Tracker.ACTIONS.SUCCESS,
							label: 'facebook-login'
						});
						// show and hide appropriate sections
						toggle();
					} else {
						error(data.msg);
					}
				},
				onErrorCallback: error
			});
		}

		/**
		 * Try to connect the user to facebook
		 * @param {Object} e Event object
		 */
		function connect(e) {
			e.preventDefault();

			// @see http://developers.facebook.com/docs/reference/javascript/FB.login/
			window.FB.login(loginCallback, {
				scope: 'email'
			});
		}

		/**
		 * Call the backend to disconnect with facebook
		 * @param {Object} e Event object
		 */
		function disconnect(e) {
			var fbFromExisting = $disconnectWrapper.attr('data-fb-from-exist'),
				disconnectMsg = fbFromExisting ? 'fbconnect-disconnect-info-existing' : 'fbconnect-disconnect-info';

			e.preventDefault();

			$.nirvana.sendRequest({
				controller: 'FacebookClient',
				method: 'disconnectFromFB',
				format: 'json',
				data: {token: mw.user.tokens.get('editToken')},
				type: 'POST',
				callback: function (data) {
					if (data.status === 'ok') {
						new window.BannerNotification()
							.setType('confirm')
							.setContent($.msg(disconnectMsg))
							.show();
						window.Wikia.Tracker.track({
							category: 'user-sign-up',
							trackingMethod: 'both',
							action: window.Wikia.Tracker.ACTIONS.CLICK,
							label: 'fb-disconnect'
						});
						// show and hide appropriate sections
						toggle();
					} else {
						error(data.msg);
					}
				},
				onErrorCallback: error
			});
		}

		/**
		 * Bind click events to DOM objects
		 */
		function bindEvents() {
			$connectLink.on('click', connect);
			$disconnectLink.on('click', disconnect);
			$disconnectButton.on('click', disconnect);
		}

		/**
		 * Generic error handling function
		 * @param {string} [msg] Optional error message
		 */
		function error(msg) {
			if (typeof msg !== 'string') {
				msg = $.msg('oasis-generic-error');
			}

			new window.BannerNotification(msg, 'error')
				.show();
		}

		function facebookError() {
			$(document).on('tab-fbconnect-prefstext-click', function () {
				var $tabContentContainer = $('#mw-prefsection-fbconnect-prefstext');

				// Disable all links within the tab
				$tabContentContainer
					.find('a')
					.css('pointer-events', 'none');

				// Throw an error message up
				function createModal(uiModal) {
					var modalConfig = {
						vars: {
							id: 'fbErrorModal',
							size: 'medium',
							title: $.msg('fbconnect-error-fb-unavailable-title'),
							content: $.msg('fbconnect-error-fb-unavailable-text')
						}
					};
					uiModal.createComponent(modalConfig, function (errorModal) {
						errorModal.show();
					});
				}

				require(['wikia.ui.factory'], function (uiFactory) {
					$.when(uiFactory.init('modal'))
						.then(createModal);
				});
			});
		}

		/**
		 * Return public methods
		 */
		return {
			// Get the Singleton instance if one exists or create one if it doesn't
			getInstance: function () {
				if (!instance) {
					instance = init();
				}
				return instance;
			}
		};

	})();

	// instantiate singleton on DOM ready
	$(fbPreferences.getInstance);
})(window, jQuery, mediaWiki);
