define('ext.wikia.curatedTour.tourManager',
	[
		'wikia.cache',
		'wikia.nirvana'
	],
	function (cache, nirvana) {
		"use strict";

		var controller = 'CuratedTourController',
			wikiId = mw.config.get('wgCityId'),
			currentTourCacheKey = 'currentCuratedTour:' + wikiId;

		function getPlan(callback) {
			var currentTour = cache.get(currentTourCacheKey);

			if (currentTour === null) {
				nirvana.sendRequest({
					controller: controller,
					method: 'getCuratedTourData',
					type: 'GET',
					callback: function (json) {
						callback(json.data);
						cache.set(currentTourCacheKey, json.data, cache.CACHE_SHORT);
					}
				});
			} else {
				callback(currentTour);
			}
		}

		function savePlan(tourPlan, callback) {
			nirvana.sendRequest({
				controller: controller,
				method: 'setCuratedTourData',
				data: {
					editToken: mw.user.tokens.get('editToken'),
					currentTourData: tourPlan
				},
				callback: function (json) {
					callback(json);
				}
			});
		}

		return {
			getPlan: getPlan,
			savePlan: savePlan
		}
	}
);
