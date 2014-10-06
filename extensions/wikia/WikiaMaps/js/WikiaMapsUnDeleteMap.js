define(
	'wikia.maps.undeleteMap',
	[
		'jquery',
		'wikia.querystring',
		'wikia.maps.config'
	], function ($, qs, config) {
	'use strict';
	var mapId = $('iframe[name=wikia-interactive-map]').data('mapid');

	/**
	 * @desc Show error message
	 * @param {string} error - error message
	 */
	function showError(error) {
		GlobalNotification.show(error, 'error');
	}

	function init() {
		$.nirvana.sendRequest({
			controller: 'WikiaMapsMap',
			method: 'updateMapDeletionStatus',
			type: 'POST',
			data: {
				mapId: mapId,
				deleted: config.constants.mapNotDeleted
			},
			callback: function (response) {
				var redirectUrl = response.redirectUrl;
				if (redirectUrl) {
					qs(redirectUrl).goTo();
				} else {
					showError(response);
				}
			},
			onErrorCallback: function (response) {
				showError(utils.getNirvanaExceptionMessage(response));
			}
		});
	}

	return {
		init: init
	};
});
