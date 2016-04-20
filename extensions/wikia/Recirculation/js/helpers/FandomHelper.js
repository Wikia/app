/*global define*/
define('ext.wikia.recirculation.helpers.fandom', [
	'jquery',
	'wikia.abTest',
	'wikia.nirvana',
	'wikia.mustache'
], function ($, abTest, nirvana, Mustache) {
	var options = {
		limit: 3
	};

	function loadData() {
		var deferred = $.Deferred();

		nirvana.sendRequest({
			controller: 'RecirculationApi',
			method: 'getFandomPosts',
			format: 'json',
			type: 'get',
			data: {
				type: 'recent_popular'
			},
			callback: function(data) {
				deferred.resolve(formatData(data));
			}
		});

		return deferred.promise();
	}

	function formatData(data) {
		var items = [];

		$.each(data.posts, function(index, item) {
			if (items.length < options.limit) {
				item.thumbnail = item.image_url;
				item.index = index;
				items.push(item);
			}
		});

		return {
			title: data.title,
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
