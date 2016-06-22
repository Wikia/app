/*global define*/
define('ext.wikia.recirculation.helpers.fandom', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.nirvana',
	'wikia.mustache'
], function ($, w, abTest, nirvana, Mustache) {

	return function(config) {
		var defaults = {
				limit: 3,
				type: 'recent_popular'
			},
			options = $.extend({}, defaults, config);

		function loadData() {
			var deferred = $.Deferred();

			nirvana.sendRequest({
				controller: 'RecirculationApi',
				method: 'getFandomPosts',
				format: 'json',
				type: 'get',
				data: {
					type: options.type,
					cityId: w.wgCityId
				},
				callback: function(data) {
					data = formatData(data);
					if (data.items && data.items.length >= options.limit ) {
						deferred.resolve(data);
					} else {
						deferred.reject('Recirculation widget not shown - Not enough items returned from Fandom API');
					}
				}
			});

			return deferred.promise();
		}

		function formatData(data) {
			var items = [];

			$.each(data.posts, function(index, item) {
				if (items.length < options.limit) {
					item.thumbnail = item.image_url || item.thumbnail;
					item.index = index;
					items.push(item);
				}
			});

			return {
				title: data.title,
				items: items
			};
		}

		return {
			loadData: loadData
		}
	}
});
