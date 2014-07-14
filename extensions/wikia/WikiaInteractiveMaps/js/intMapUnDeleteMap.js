define('wikia.intMaps.unDeleteMap', ['jquery', 'wikia.querystring', 'wikia.intMap.utils'], function ($, qs, utils) {
	'use strict';
	var mapId = $('iframe[name=wikia-interactive-map]').data('mapid');

	function init() {
		$.nirvana.sendRequest({
			controller: 'WikiaInteractiveMaps',
			method: 'deleteMap',
			type: 'POST',
			data: {
				mapId: mapId,
				deleted: utils.mapDeleted.MAP_NOT_DELETED
			},
			callback: function(response) {
				var redirectUrl = response.redirectUrl;
				if (redirectUrl) {
					qs(redirectUrl).goTo();
				} else {
					showError();
				}
			},
			onErrorCallback: function(response) {
				utils.handleNirvanaException(modal, response);
			}
		});
	}

	return {
		init: init
	};
});