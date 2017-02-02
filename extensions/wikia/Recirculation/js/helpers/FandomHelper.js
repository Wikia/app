define('ext.wikia.recirculation.helpers.fandom', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.nirvana'
], function ($, w, abTest, nirvana) {
	'use strict';

	return function(config) {
		var defaults = {
				limit: 3,
				type: 'recent_popular',
				ignoreError: false,
				fill: false
			},
			options = $.extend({}, defaults, config);

		function loadData() {
			var deferred = $.Deferred();

			nirvana.sendRequest({
				controller: 'RecirculationApi',
				method: 'getFandomPosts',
				format: 'json',
				type: 'get',
				scriptPath: w.wgCdnApiUrl,
				data: {
					type: options.type,
					cityId: w.wgCityId,
					limit: options.limit,
					fill: options.fill
				},
				callback: function(data) {
					data = formatData(data);
					if (data.items && data.items.length >= options.limit ) {
						deferred.resolve(data);
					} else {
						if (options.ignoreError) {
							deferred.resolve({
								title: data.title,
								items: []
							});
						} else {
							deferred.reject('Recirc widget not shown. Not enough items returned from Fandom API');
						}
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
				items: items.sort(sortItem)
			};
		}

		function sortItem(a, b) {
			if (a.type === 'recent_popular' && b.type !== 'recent_popular') {
				return 1;
			}

			if (b.type === 'recent_popular' && a.type !== 'recent_popular') {
				return -1;
			}

			return b.isVideo - a.isVideo;
		}

		return {
			loadData: loadData
		};
	};
});
