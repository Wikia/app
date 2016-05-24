/*global define*/
define('ext.wikia.recirculation.helpers.curatedContent', [
	'jquery',
	'wikia.nirvana',
	'wikia.cache',
	'wikia.underscore'
], function ($, nirvana, cache, _) {

	return function(config) {
		var defaults = {
				limit: 1
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
					type: 'curated'
				},
				callback: function(data) {
					data = formatData(data);
					if (data && data.length > 0 ) {
						deferred.resolve(data);
					} else {
						deferred.reject();
					}
				}
			});

			return deferred.promise();
		}

		function formatData(data) {
			var items = [];
			var posts = _.shuffle(data.posts);

			$.each(posts, function(index, item) {
				if (items.length < options.limit && !hasSeen(item)) {
					items.push(item);
				}
			});

			return items;
		}

		function hasSeen(post) {
			return cache.get(key(post));
		}

		function setSeen(post) {
			return cache.set(key(post), true, cache.CACHE_STANDARD);
		}

		function key(post) {
			return 'recirculation:curated:' + post.url;
		}

		function injectContent(data) {
			var deferred = $.Deferred();

			loadData().then(function(curatedPosts) {
				var randomIndex = Math.floor(Math.random() * data.items.length);

				data.items.splice(randomIndex, 1, curatedPosts[0]);

				data.items.map(function(item, index) {
					item.index = index;
					return item;
				});

				setSeen(curatedPosts[0]);
				deferred.resolve(data);
			}).fail(function() {
				deferred.resolve(data)
			});

			return deferred.promise();
		}

		return {
			injectContent: injectContent,
			loadData: loadData
		}
	}
});
