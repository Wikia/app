/* global require, window */
require(['jquery', 'mw', 'wikia.loader', 'wikia.nirvana', 'BannerNotification'], function ($, mw, loader, nirvana, BannerNotification) {
	'use strict';

	function notify(type) {
		var messageArgs = Array.prototype.slice.call(arguments, 1);

		new BannerNotification()
			.setContent(mw.message.apply(null, messageArgs).escaped())
			.setType(type)
			.show();
	}

	function showFacebookConnectSuccess() {
		$('.auth-preferences')
			.removeClass('facebook-state-disconnected')
			.addClass('facebook-state-linked');

		notify('confirm', 'fbconnect-preferences-connected');
	}

	function showFacebookDisconnectSuccess() {
		$('.auth-preferences')
			.removeClass('facebook-state-linked')
			.addClass('facebook-state-disconnected');

		notify('confirm', 'fbconnect-disconnect-info');
	}

	function showFacebookConnectFailure(res) {
		// Prevent showing two error messages
		if (!res) {
			return;
		}

		if (res.status === 400) {
			var userName = mw.user.name();

			notify('error', 'fbconnect-error-fb-account-in-use', userName);

			return;
		}

		showFacebookConnectGenericError();
	}

	function showFacebookAuthorizationFailure() {
		notify('error', 'fbconnect-preferences-connected-error');
	}

	function showFacebookConnectGenericError() {
		notify('error', 'fbconnect-unknown-error');
	}

	function showGoogleConnectSuccess() {
		notify('confirm', 'google-connect-account-connected');
	}

	function showGoogleDisconnectSuccess() {
		notify('confirm', 'google-connect-account-disconnected');
	}

	function showGoogleConnectGenericError() {
		notify('error', 'google-connect-unknown-error');
	}

	function showTwitchConnectSuccess() {
		notify('confirm', 'twitch-connect-account-connected');
	}

	function showTwitchDisconnectSuccess() {
		notify('confirm', 'twitch-connect-account-disconnected');
	}

	function showTwitchConnectGenericError() {
		notify('error', 'twitch-connect-unknown-error');
	}

	function linkFacebookAccount(fbAuthResponse) {
		var accessToken = fbAuthResponse.accessToken,
			editToken = mw.user.tokens.get('editToken');

		return nirvana.sendRequest({
			controller: 'AuthPreferences',
			method: 'linkFacebookAccount',
			data: {
				accessToken: accessToken,
				token: editToken
			}
		});
	}

	function disconnectFacebookAccount() {
		var editToken = mw.user.tokens.get('editToken');

		return nirvana.sendRequest({
			controller: 'AuthPreferences',
			method: 'unlinkFacebookAccount',
			data: {
				token: editToken
			}
		});
	}

	function loadFacebookSdk() {
		return loader({
			type: loader.LIBRARY,
			resources: ['facebook']
		}).done(function () {
			var appId = mw.config.get('fbAppId');

			window.FB.init({
				appId: appId,
				cookie: true,
				version: 'v7.0'
			});

			return $.Deferred().resolve();
		});
	}

	function promptUserToLogInWithFacebook() {
		var dfd = $.Deferred();

		window.FB.login(function (response) {
			if (response.authResponse) {
				dfd.resolve(response.authResponse);
				return;
			}

			dfd.reject();
		}, { scope: 'email' });

		return dfd;
	}

	function redirectTo(url) {
		window.location.href = url;
	}

	$(function () {
		$('#facebook-connect-button').on('click', function (event) {
			event.preventDefault();

			loadFacebookSdk()
				.then(promptUserToLogInWithFacebook)
				.fail(showFacebookAuthorizationFailure)
				.then(linkFacebookAccount)
				.done(showFacebookConnectSuccess)
				.fail(showFacebookConnectFailure);
		});

		$('#facebook-disconnect-button, #fbDisconnectPreferences a').on('click', function (event) {
			event.preventDefault();

			disconnectFacebookAccount()
				.done(showFacebookDisconnectSuccess)
				.fail(showFacebookConnectGenericError);
		});
	});

	window.addEventListener('message', function (event) {
		var data = JSON.parse(event.data),
			externalAuthData = data && data.externalAuth;

		if (externalAuthData) {
			switch (true) {
				case !!externalAuthData.redirectUrl:
					redirectTo(externalAuthData.redirectUrl);
					break;
				case externalAuthData.googleConnectStatus === 'connected':
					showGoogleConnectSuccess();
					break;
				case externalAuthData.googleConnectStatus === 'disconnected':
					showGoogleDisconnectSuccess();
					break;
				case externalAuthData.googleConnectStatus === 'error':
					showGoogleConnectGenericError();
					break;
				case externalAuthData.twitchConnectStatus === 'connected':
					showTwitchConnectSuccess();
					break;
				case externalAuthData.twitchConnectStatus === 'disconnected':
					showTwitchDisconnectSuccess();
					break;
				case externalAuthData.twitchConnectStatus === 'error':
					showTwitchConnectGenericError();
					break;
				default:
			}
		}
	});
});
