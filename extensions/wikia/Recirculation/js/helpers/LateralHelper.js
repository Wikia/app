/*global define*/
define('ext.wikia.recirculation.helpers.lateral', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
], function ($, w, abTest) {
	var libraryLoaded = false,
		options = {
			count: 5,
			width: 160,
			height: 90,
			type: 'fandom'
		};

	function loadLateral(callback) {
		if (libraryLoaded && callback && typeof callback === 'function') {
			callback(w.lateral);
		}

		var lateralScript = document.createElement('script'),
			url = 'https://assets.lateral.io/recommendations.js';

		lateralScript.src = url;

		document.getElementsByTagName('body')[0].appendChild(lateralScript);

		// This function is called when the Lateral script has loaded
		w.onLoadLateral = function(lateral) {
			w.lateral = lateral;
			libraryLoaded = true;

			if (callback && typeof callback === 'function') {
				callback(lateral);
			}
		}
	}

	function recommendFandom(lateral, callback) {
		lateral.recommendationsFandom({
			count: options.count,
			onResults: callback
		});
	}

	function recommendCommunity(lateral, callback) {
		lateral.recommendationsWikia({
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
			foundData = true;
			deferred.resolve(formatData(data));
		}

		loadLateral(function(lateral) {
			switch (type) {
				case 'fandom':
					recommendFandom(lateral, resolveFormattedData);
					break;
				case 'community':
					recommendCommunity(lateral, resolveFormattedData);
					break;
			}
		});

		// If we don't recieve anything in 3 seconds we want to reject the promise
		setTimeout(function() {
			if (foundData) {
				return;
			} else {
				deferred.reject();
			}
		}, 3000);

		return deferred.promise();
	}

	function formatData(data) {
		var items = [];

		$.each(data, function(index, item) {
			if (!item.image) {
				return;
			}
			item.thumbnail = item.image;
			item.index = index;
			items.push(item);
		});

		var title = options.type === 'fandom' ? $.msg('recirculation-fandom-title') : $.msg('recirculation-incontent-title');

		return {
			title: title,
			items: items.slice(0, options.count)
		};
	}

	return function(config) {
		$.extend(options, config);

		return {
			loadData: loadData
		}
	}
});
