/*global define*/
define('ext.wikia.recirculation.helpers.data', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.nirvana'
], function ($, w, abTest, nirvana) {

	return function() {

		function loadData() {
			return $.when(loadAll(), loadArticles())
				.done(function(data, articles) {
					data.articles = articles;
					return data;
				});
		}

		function loadAll() {
			var deferred = $.Deferred();

			nirvana.sendRequest({
				controller: 'RecirculationApi',
				method: 'getAllPosts',
				format: 'json',
				type: 'get',
				scriptPath: w.wgCdnApiUrl,
				data: {
					cityId: w.wgCityId
				},
				callback: function(data) {
					data = formatFandom(data);
					deferred.resolve(data);
				}
			});

			return deferred.promise();
		}

		function loadArticles() {
			var deferred = $.Deferred();

			nirvana.sendRequest({
				controller: 'ArticlesApi',
				method: 'getTop',
				format: 'json',
				type: 'get',
				data: {
					'abstract': 0,
					'expand': 1,
					'height': 220,
					'limit': 8,
					'namespaces': 0,
					'width': 385
				},
				callback: function(data) {
					data = formatArticles(data);
					deferred.resolve(data);
				}
			});

			return deferred.promise();
		}

		function formatFandom(data) {
			var fandomPosts = [];

			$.each(data.fandom.items, function(index, item) {
				item.thumbnail = item.image_url;
				item.index = index;
				fandomPosts.push(item);
			});

			data.fandom.items = fandomPosts;

			return {
				title: data.title,
				fandom: data.fandom,
				discussions: data.discussions,
			};
		}

		function formatArticles(data) {
			var articles = [];

			$.each(data.items, function(index, item) {
				item.source = 'wiki';
				item.thumbnail = item.thumbnail;
				item.index = index;
				articles.push(item);
			});

			articles.sort(sortThumbnails);

			return articles.slice(0,5);
		}

		function sortThumbnails(a, b) {
			if (a.thumbnail && !b.thumbnail) {
				return -1;
			}

			if (!a.thumbnail && b.thumbnail) {
				return 1;
			}

			return 0;
		}

		return {
			loadData: loadData
		};
	};
});
