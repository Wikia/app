/*global define*/
define('ext.wikia.recirculation.helpers.liftigniter', [
	'jquery',
	'wikia.window',
	'wikia.thumbnailer'
], function ($, w, thumbnailer) {

	return function(config) {
		var defaults = {
				count: 5,
				width: 320,
				height: 180
			},
			options = $.extend({}, defaults, config);

		function loadData(waitToFetch) {
			var deferred = $.Deferred(),
				registerOptions = {
					max: options.count * 2,
					widget: options.widget,
					callback: function(response) {
						deferred.resolve(formatData(response));
					}
				};

			if (!w.$p) {
				return deferred.reject('Liftigniter library not found').promise();
			}

			if (options.widget === 'fandom-rec') {
				registerOptions.opts = {resultType: "fandom"}
			}

			// Callback renders and injects results into the placeholder.
			w.$p('register', registerOptions);

			// Executes the registered call.
			if (!waitToFetch) {
				w.$p('fetch');
			}

			return deferred.promise();
		}

		function formatData(data) {
			var items = [],
				title;

			if (options.widget === 'fandom-rec') {
				title = $.msg('recirculation-fandom-title');
			} else {
				title = $.msg('recirculation-incontent-title');
			}

			$.each(data.items, function(index, item) {
				if (items.length < options.count && item.thumbnail) {
					if (options.widget === 'fandom-rec') {
						item.title = item.title.replace(' - Fandom - Powered by Wikia', '');
					} else {
						item.thumbnail = thumbnailer.getThumbURL(item.thumbnail, 'image', options.width, options.height);
					}

					item.index = index;
					item.source = 'liftigniter';
					items.push(item);
				}
			});

			return {
				title: title,
				items: items
			};
		}

		function setupTracking(elements) {
			var trackOptions = {
				elements: elements,
				name: options.widget,
				source: 'LI'
			};

			if (options.widget === 'fandom-rec') {
				trackOptions.opts = {resultType: "fandom"}
			}
			w.$p('track', trackOptions);
		}

		return {
			setupTracking: setupTracking,
			loadData: loadData
		}
	}
});
