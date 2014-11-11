/* global FB, wgServer */

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
			controller: 'SpecialFacebookConnect',
			method: 'index',
			callback: function (data) {
				debugger;
				if (data.status === 'ok') {
					window.Wikia.Tracker.track({
						category: 'force-login-modal',
						trackingMethod: 'both',
						action: window.Wikia.Tracker.ACTIONS.SUCCESS,
						label: 'facebook-login'
					});

					location.reload();
				} else {
					window.location.href = destUrl;
				}
			}
		});
	}

	// handle disconnecting from facebook
	$('#fbConnectDisconnect').click(function () {
		$('#fbConnectDisconnectDone').hide();
		$('#fbDisconnectProgress').show();
		$.postJSON(wgServer + '/wikia.php?controller=FacebookClient&method=disconnectFromFB&format=json',
			null,
			function (data) {
				if (data.status === 'ok') {
					$('#fbDisconnectLink').hide();
					$('#fbDisconnectProgressImg').hide();
					$('#fbDisconnectDone').show();
					$('#fbConnectDisconnectDone').show();

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