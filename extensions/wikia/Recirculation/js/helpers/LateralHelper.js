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
			count: options.count,
			width: options.width,
			height: options.height,
			onResults: callback
		});
	}

	function loadData() {
		var deferred = $.Deferred(),
			type = options.type;

		function resolveFormattedData(data) {
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

		return deferred.promise();
	}

	function formatData(data) {
		var items = [];

		$.each(data, function(index, item) {
			item.thumbnail = item.image || placeholderImage;
			item.index = index;
			items.push(item);
		});

		var title = options.type === 'fandom' ? $.msg('recirculation-fandom-title') : $.msg('recirculation-incontent-title');

		return {
			title: title,
			items: items
		};
	}

	return function(config) {
		$.extend(options, config);

		return {
			loadData: loadData
		}
	}
});
