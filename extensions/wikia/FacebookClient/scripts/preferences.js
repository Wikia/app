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
		$.nirvana.sendRequest({
			controller: 'FacebookClient',
			method: 'connectLoggedInUser',
			format: 'json',
			callback: function (data) {
				if (data.status === 'ok') {

					window.GlobalNotification.show($.msg('fbconnect-preferences-connected'), 'confirm');

					window.Wikia.Tracker.track({
						category: 'force-login-modal', // todo: this is not always correct
						trackingMethod: 'both',
						action: window.Wikia.Tracker.ACTIONS.SUCCESS,
						label: 'facebook-login'
					});
				} else {
					window.GlobalNotification.show($.msg('fbconnect-preferences-connected-error'), 'error');
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