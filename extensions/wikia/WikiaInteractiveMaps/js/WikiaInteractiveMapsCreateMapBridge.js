define('wikia.intMaps.createMap.bridge', ['jquery', 'wikia.window', 'wikia.intMaps.createMap.config'], function($, w, config) {
	'use strict';

	/**
	 * @desc Sends and AJAX request to upload map image
	 * @param {object} form - html node elementś
	 * @param {function} success - success callback function
	 * @param {function} error - error callback function
	 */

	function uploadMapImage(form, success, error) {
		$.ajax({
			contentType: false,
			data: new FormData(form),
			processData: false,
			type: 'POST',
			url: w.wgScriptPath + config.uploadEntryPoint,

			success: function(response) {
				var data = response.results;

				if (data && data.success) {
					success(data);
				} else {
					error(response);
				}
			},

			error: function(response) {
				error(response);
			}
		});
	}

	/**
	 * @desc Sends and AJAX request to create a map
	 * @param {object} data - request parameters required to create a map
	 * @param {function} success - success callback function
	 * @param {function} error - error callback function
	 */

	function createMap(data, success, error) {
		$.nirvana.sendRequest({
			controller: 'WikiaInteractiveMaps',
			method: 'createMap',
			format: 'json',
			data: data,
			callback: function(response) {
				var data = response.results;

				if (data && data.success) {
					success(data);
				} else {
					error(response);
				}
			},
			onErrorCallback: function(response) {
				error(response);
			}
		});
	}

	return {
		uploadMapImage: uploadMapImage,
		createMap: createMap
	};
});
