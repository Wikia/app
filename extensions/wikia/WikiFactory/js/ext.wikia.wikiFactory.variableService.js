/* global define */
define('ext.wikia.wikiFactory.variableService', [
	'ext.wikia.wikiFactory.requestManager',
	'BannerNotification',
	'mw'
], function (requestManager, BannerNotification, mw) {
	'use strict';

	function performRequestWithNotification(formData, successMsg) {
		requestManager.doApiRequest(formData, function (xhrEvent) {
			var xmlHttpRequest = xhrEvent.target;

			if (xmlHttpRequest.readyState !== XMLHttpRequest.DONE) {
				return;
			}

			if (xmlHttpRequest.status === 200 && !xmlHttpRequest.response.error) {
				new BannerNotification(successMsg).show();
			} else {
				new BannerNotification(xmlHttpRequest.response.error.info, 'error').show();
			}
		});
	}

	return {
		saveVariable: function (event) {
			event.preventDefault();

			var formData = new FormData(event.target.parentNode);

			formData.append('token', mw.user.tokens.get('editToken'));
			formData.append('action', 'wfsavevariable');
			formData.append('format', 'json');

			performRequestWithNotification(formData, 'Parse OK, variable saved');
		},
		removeVariable: function (event) {
			event.preventDefault();

			var formData = new FormData(event.target.parentNode);

			formData.append('token', mw.user.tokens.get('editToken'));
			formData.append('action', 'wfremovevariable');
			formData.append('format', 'json');

			performRequestWithNotification(formData, 'Value of variable was removed');
		}
	};
});
