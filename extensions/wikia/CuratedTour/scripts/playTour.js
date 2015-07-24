define('ext.wikia.curatedTour.playTour',
	[
		'jquery',
		'wikia.cache'
	],
	function ($, cache) {
		"use strict";

		function init() {

		}

		function getCurrentTour(callback) {
			var currentTour = cache.get(currentTourCacheKey);

			if (currentTour === null) {
				nirvana.sendRequest({
					controller: 'CuratedTourController',
					method: 'getCuratedTourData',
					type: 'GET',
					callback: function (json) {
						renderEditBox(json.data);
					}
				});
			} else {
				renderEditBox(currentTour);
			}
		}
	}
);
