define('wikia.intMaps.unDeleteMap', ['jquery', 'wikia.querystring', 'wikia.intMap.utils'], function ($, qs, utils) {
	'use strict';
	var mapId = $('iframe[name=wikia-interactive-map]').data('mapid');

	/**
	 * @desc Show error message
	 * @param error error message
	 */
	function showError(error) {
		GlobalNotification.show(error, 'error');
	}

	function init() {
		$.nirvana.sendRequest({
			controller: 'WikiaInteractiveMaps',
			method: 'updateMapDeletionStatus',
			type: 'POST',
			data: {
				mapId: mapId,
				deleted: utils.mapDeleted.mapNotDeleted
			},
			callback: function(response) {
				var redirectUrl = response.redirectUrl;
				if (redirectUrl) {
					qs(redirectUrl).goTo();
				} else {
					showError(response);
				}
			},
			onErrorCallback: function(error) {
				showError(error.statusText);
			}
		});
	}

	return {
		init: init
	};
});
