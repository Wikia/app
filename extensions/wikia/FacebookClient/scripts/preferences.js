/* global FB, wgServer, wgScript, wgPageName */

$(function () {
	'use strict';

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

	// BugId:93549
	$.loadFacebookAPI(function () {
		FB.XFBML.parse(document.getElementById('preferences'));
	});
});

function sendToConnectOnLogin(){
	'use strict';

	window.FB.getLoginStatus(function () {
		var postURL,
			destUrl = wgServer + wgScript +
			'?title=Special:FacebookConnect' +
			'&returnto=' + encodeURIComponent(wgPageName) +
			'&returntoquery=' + encodeURIComponent(window.wgPageQuery || '');

		$('#fbConnectModalWrapper').remove();

		postURL = '/wikia.php?controller=SpecialFacebookConnect&method=checkCreateAccount&format=json';
		$.postJSON(postURL, function (data) {
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
		});
	});
}
