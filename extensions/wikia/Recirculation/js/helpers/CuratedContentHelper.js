define('ext.wikia.recirculation.helpers.curatedContent', [
	'jquery',
	'underscore',
	'wikia.window',
	'wikia.nirvana',
	'wikia.cache',
	'ext.wikia.recirculation.tracker'
], function ($, _, w, nirvana, cache , tracker) {
	'use strict';

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
				scriptPath: w.wgCdnApiUrl,
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
				},
				onErrorCallback: function() {
					deferred.reject();
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
			return 'recirculation:curated:' + post.id;
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
				deferred.resolve(data);
			});

			return deferred.promise();
		}

		function setupTracking($html) {
			var $curatedItem = $html.find('.item-curated'),
				label,
				slot,
				id;

			if ($curatedItem.length) {
				id = $curatedItem.data('id');
				slot = $curatedItem.data('index') + 1;
				label = 'CURATED=' + id + '=slot_' + slot;

				tracker.trackImpression(label);

				$curatedItem.on('mousedown', 'a', function() {
					tracker.trackClick(label);
				});
			}

			return $html;
		}

		return {
			injectContent: injectContent,
			setupTracking: setupTracking,
			loadData: loadData
		};
	};
});
