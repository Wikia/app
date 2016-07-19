/*global define*/
define('ext.wikia.recirculation.helpers.lateral', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
], function ($, w, abTest) {
	var libraryLoaded = false,
		queue = [];

	function loadLateral(callback) {
		queue.push(callback);

		if (w.lateral) {
			processQueue(w.lateral);
		}
		if (!libraryLoaded) {
			var lateralScript = document.createElement('script');
			libraryLoaded = true;

			lateralScript.src = 'https://assets.lateral.io/recommendations.js';
			document.getElementsByTagName('body')[0].appendChild(lateralScript);

			// This function is called when the Lateral script has loaded
			w.onLoadLateral = function(lateral) {
				w.lateral = lateral;
				processQueue(lateral);
			}
		}
	}

	function processQueue(lateral) {
		while(queue.length > 0) {
			var callback = queue.shift();

			callback(lateral);
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
			return lateral.recommendationsHybrid({
				recommendFrom: 'fandom',
				count: options.count,
				onResults: callback
			});
		}

		function recommendCommunity(lateral, callback) {
			return lateral.recommendationsHybrid({
				recommendFrom: 'self',
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
				if (data && data.length > 0) {
					deferred.resolve(formatData(data));
				} else {
					deferred.reject('No Lateral results returned for this content');
				}

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
					deferred.reject('No Lateral data found for ' + type);
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
