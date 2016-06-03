/*global define*/
define('ext.wikia.recirculation.helpers.data', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.nirvana'
], function ($, w, abTest, nirvana) {

	return function() {

		function loadData() {
			var deferred = $.Deferred();

			nirvana.sendRequest({
				controller: 'RecirculationApi',
				method: 'getAllPosts',
				format: 'json',
				type: 'get',
				callback: function(data) {
					data = formatData(data);
					deferred.resolve(data);
				}
			});

			return deferred.promise();
		}

		function formatData(data) {
			var fandomPosts = [],
				articles = [];

			$.each(data.fandom.items, function(index, item) {
				item.thumbnail = item.image_url;
				item.index = index;
				fandomPosts.push(item);
			});

			data.fandom.items = fandomPosts;

			$.each(data.articles, function(index, item) {
				item.source = 'wiki';
				item.thumbnail = item.thumbnail;
				item.index = index;
				articles.push(item);
			});

			return {
				title: data.title,
				fandom: data.fandom,
				discussions: data.discussions,
				articles: articles
			};
		}

		return {
			loadData: loadData
		};
	};
});
