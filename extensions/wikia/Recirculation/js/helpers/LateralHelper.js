/*global define*/
define('ext.wikia.recirculation.helpers.lateral', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
], function ($, w, abTest) {
	var options = {
		count: 5,
		width: 268,
		height: 166,
		type: 'fandom'
	};

	function loadLateral() {
		var lateralScript = document.createElement('script'),
			url = 'https://assets.lateral.io/recommendations.js';

		lateralScript.src = url;

		document.getElementsByTagName('body')[0].appendChild(lateralScript);
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

		// This function is called when the Lateral script has loaded
		w.onLoadLateral = function(lateral) {
			switch (type) {
				case 'fandom':
					recommendFandom(lateral, resolveFormattedData);
					break;
				case 'community':
					recommendCommunity(lateral, resolveFormattedData);
					break;
			}
		}

		loadLateral();

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
