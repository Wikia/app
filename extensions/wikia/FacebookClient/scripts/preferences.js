/* global FB, wgServer, wgScript */

$(function () {
	'use strict';

	$('#fbConnectDisconnect').click(function () {
		$('#fbConnectDisconnectDone').hide();
		$('#fbDisconnectProgress').show();
		$.postJSON(wgServer + wgScript + '?controller=FacebookClient&method=disconnectFromFB',
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

	// BugId:93549
	$.loadFacebookAPI(function () {
		FB.XFBML.parse(document.getElementById('preferences'));
	});
});
