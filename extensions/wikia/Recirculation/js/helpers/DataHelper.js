/*global define*/
define('ext.wikia.recirculation.helpers.data', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.nirvana',
	'ext.wikia.recirculation.utils'
], function ($, w, abTest, nirvana, utils) {

	return function(options) {
		options = options || {};

		function loadData() {
			return loadArticles().then(function(articles) {
				return { items: articles };
			});
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

		function formatArticles(data) {
			var articles = [];

			$.each(data.items, function(index, item) {
				item.source = 'wiki';
				item.index = index;
				articles.push(item);
			});

			articles.sort(utils.sortThumbnails);

			return articles.slice(0,5);
		}

		return {
			loadData: loadData
		};
	};
});
