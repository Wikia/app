/*global define*/
define('ext.wikia.recirculation.helpers.lateral', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
], function ($, w, abTest) {
	var libraryLoaded = false;

	function loadLateral(callback) {
		if (libraryLoaded) {
			if (callback) {
				callback(w.lateral);
			}
			return;
		}

		var lateralScript = document.createElement('script');

		lateralScript.src = 'https://assets.lateral.io/recommendations.js';
		document.getElementsByTagName('body')[0].appendChild(lateralScript);

		// This function is called when the Lateral script has loaded
		w.onLoadLateral = function(lateral) {
			w.lateral = lateral;
			libraryLoaded = true;

			if (callback) {
				callback(lateral);
			}
		}
	}

	return function(config) {
		var defaults = {
				count: 5,
				width: 160,
				height: 90,
				type: 'fandom'
			},
			options = $.extend(defaults, config);

		function recommendFandom(lateral, callback) {
			return lateral.recommendationsFandom({
				count: options.count,
				onResults: callback
			});
		}

		function recommendCommunity(lateral, callback) {
			return lateral.recommendationsWikia({
				count: options.count * 2, // We load twice as many as we need in case some options do not have images
				width: options.width,
				height: options.height,
				onResults: callback
			});
		}

		function loadData() {
			var deferred = $.Deferred(),
				type = options.type,
				foundData = false;

			function resolveFormattedData(data) {
				deferred.resolve(formatData(data));
			}

			loadLateral(function(lateral) {
				switch (type) {
					case 'fandom':
						foundData = recommendFandom(lateral, resolveFormattedData);
						break;
					case 'community':
						foundData = recommendCommunity(lateral, resolveFormattedData);
						break;
				}

				if (!foundData) {
					deferred.reject('No data found');
				}
			});

			return deferred.promise();
		}

		function formatData(data) {
			var items = [],
				title;

			if (options.type === 'fandom') {
				title = $.msg('recirculation-fandom-title');
			} else {
				title = $.msg('recirculation-incontent-title');
			}

			$.each(data, function(index, item) {
				if (!item.image) {
					return;
				}
				item.thumbnail = item.image;
				item.index = index;
				items.push(item);
			});

			return {
				title: title,
				items: items.slice(0, options.count)
			};
		}

		return {
			loadData: loadData
		}
	}
});
