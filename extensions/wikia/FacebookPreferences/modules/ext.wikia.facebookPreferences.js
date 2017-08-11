/* global require, window */
require(['jquery', 'mw', 'wikia.loader', 'wikia.nirvana', 'BannerNotification'], function ($, mw, loader, nirvana, BannerNotification) {
	'use strict';

	function showConnectSuccess() {
		$('.facebook-preferences')
			.removeClass('facebook-state-disconnected')
			.addClass('facebook-state-linked');

		new BannerNotification()
			.setContent(mw.message('fbconnect-preferences-connected').escaped())
			.setType('confirm')
			.show();
	}

	function showDisconnectSuccess() {
		$('.facebook-preferences')
			.removeClass('facebook-state-linked')
			.addClass('facebook-state-disconnected');

		new BannerNotification()
			.setContent(mw.message('fbconnect-disconnect-info').escaped())
			.setType('confirm')
			.show();
	}

	function showConnectFailure(res) {
		// Prevent showing two error messages
		if (!res) {
			return;
		}

		if (res.status === 400) {
			var userName = mw.user.name();

			new BannerNotification()
				.setContent(mw.message('fbconnect-error-fb-account-in-use', userName).escaped())
				.setType('error')
				.show();

			return;
		}

		showGenericError();
	}

	function showAuthorizationFailure() {
		new BannerNotification()
			.setContent(mw.message('fbconnect-preferences-connected-error').escaped())
			.setType('error')
			.show();
	}

	function showGenericError() {
		new BannerNotification()
			.setContent(mw.message('fbconnect-unknown-error').escaped())
			.setType('error')
			.show();
	}

	function linkFacebookAccount(fbAuthResponse) {
		var accessToken = fbAuthResponse.accessToken,
			editToken = mw.user.tokens.get('editToken');

		return nirvana.sendRequest({
			controller: 'FacebookPreferences',
			method: 'linkAccount',
			data: {
				accessToken: accessToken,
				token: editToken
			}
		});
	}

	function disconnectFacebookAccount() {
		var editToken = mw.user.tokens.get('editToken');

		return nirvana.sendRequest({
			controller: 'FacebookPreferences',
			method: 'unlinkAccount',
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
				version: 'v2.9'
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

	$(function () {
		$('#facebook-connect-button').on('click', function (event) {
			event.preventDefault();

			loadFacebookSdk()
				.then(promptUserToLogInWithFacebook)
				.fail(showAuthorizationFailure)
				.then(linkFacebookAccount)
				.done(showConnectSuccess)
				.fail(showConnectFailure);
		});

		$('#facebook-disconnect-button, #fbDisconnectPreferences a').on('click', function (event) {
			event.preventDefault();

			disconnectFacebookAccount()
				.done(showDisconnectSuccess)
				.fail(showGenericError);
		});
	});
});
