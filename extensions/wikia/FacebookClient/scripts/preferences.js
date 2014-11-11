/* global FB, wgServer, wgScript */

$(function () {
	'use strict';

	$.loadFacebookAPI();

	// handle connecting to facebook
	$('.sso-login-facebook').on('click', function (e) {
		e.preventDefault();

		window.FB.login(loginCallback);
	});

	function loginCallback() {
		var destUrl;

		$.nirvana.sendRequest({
			controller: 'SpecialFacebookConnect',
			method: 'checkCreateAccount',
			callback: function (data) {
				// user is already connected to FB and Wikia
				if (data.status === 'ok') {
					window.Wikia.Tracker.track({
						category: 'force-login-modal', // todo: this is not always correct
						trackingMethod: 'both',
						action: window.Wikia.Tracker.ACTIONS.SUCCESS,
						label: 'facebook-login'
					});

					location.reload();
				} else {
					// send to url that will connect the accounts and then redirect to specified location
					destUrl = wgServer +
						wgScript +
						'?title=Special:FacebookConnect&returnto=' +
						encodeURIComponent(window.fbReturnToTitle || window.wgPageName) +
						'&returntoquery=' +
						encodeURIComponent(window.wgPageQuery || '');

					window.location.href = destUrl;
				}
			}
		});
	}

	// handle disconnecting from facebook
	$('#fbConnectDisconnect').click(function (e) {
		e.preventDefault();

		var $doneMessage = $('#fbConnectDisconnectDone').hide();
		$('#fbDisconnectProgress').show();

		$.postJSON(wgServer + '/wikia.php?controller=FacebookClient&method=disconnectFromFB&format=json',
			null,
			function (data) {
				if (data.status === 'ok') {
					$('#fbDisconnectLink').hide();
					$('#fbDisconnectProgressImg').hide();
					$('#fbDisconnectDone').show();
					$doneMessage.show();

					window.Wikia.Tracker.track({
						category: 'user-sign-up',
						trackingMethod: 'both',
						action: window.Wikia.Tracker.ACTIONS.CLICK,
						label: 'fb-disconnect'
					});
				} else {
					window.location.reload();
				}
			}
		);
	});
});