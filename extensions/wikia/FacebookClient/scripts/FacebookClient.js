/* global FB, wgServer, wgScript, wgPageName */

(function () {
	'use strict';

	/**
	 * An optional handler to use in fbOnLoginJsOverride for when a user logs in via facebook connect.
	 * This will redirect to Special:Connect with the returnto variables configured properly.
	 * Ported over from fbconnect.js and could use some refactoring.
	 */
	window.sendToConnectOnLogin = function (){
		FB.getLoginStatus(function () {
			var postURL,
				destUrl = wgServer + wgScript +
					'?title=Special:FacebookConnect' +
					'&returnto=' + encodeURIComponent(wgPageName) +
					'&returntoquery=' + encodeURIComponent(window.wgPageQuery || '');

			$('#fbConnectModalWrapper').remove();

			postURL = '/wikia.php?controller=SpecialFacebookConnect&method=checkCreateAccount&format=json';
			$.postJSON(postURL, function (data) {
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
			});
		});
	};
})();