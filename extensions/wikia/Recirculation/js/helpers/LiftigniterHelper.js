define('ext.wikia.recirculation.helpers.liftigniter', [
	'jquery',
	'wikia.window',
	'wikia.thumbnailer'
], function ($, w, thumbnailer) {
	'use strict';

	var helper = function (config) {
		var defaults = {
				max: 5,
				width: 320,
				height: 180,
				flush: false
			},
			options = $.extend({}, defaults, config);

		function loadData() {
			var deferred = $.Deferred(),
				registerOptions = {
					max: options.max * 2, // We want to load twice as many because we filter based on thumbnails
					widget: options.widget,
					callback: function (response) {
						deferred.resolve(formatData(response));
					}
				};

			if (!w.$p) {
				return deferred.reject('Liftigniter library not found').promise();
			}

			if (options.opts) {
				registerOptions.opts = options.opts;
			}

			// Callback renders and injects results into the placeholder.
			w.$p('register', registerOptions);

			if (options.flush) {
				w.$p('fetch');
			}

			return deferred.promise();
		}

		function formatData(data) {
			var items = [],
				title = '';

			if (options.title) {
				title = options.title;
			}

			$.each(data.items, function (index, item) {
				item.isWiki = false;

				if (items.length < options.max && item.thumbnail) {
					item.source = options.source;
					item.meta = options.widget;
					item.index = index;

                    if (item.source === 'wiki') {
                        item.isWiki = true;
                        item.thumbnail = thumbnailer.getThumbURL(item.thumbnail, 'image', options.width, options.height);
                    }

					items.push(item);
				}
			});

			return {
				title: title,
				items: items
			};
		}

		function setupTracking() {
			var elements = $('.recirculation-unit .item[data-meta="' + options.widget + '"]').get(),
				trackOptions = {
					elements: elements,
					name: options.widget,
					source: 'LI'
				};

			if (options.opts) {
				trackOptions.opts = options.opts;
			}
			w.$p('track', trackOptions);
		}

		return {
			setupTracking: setupTracking,
			loadData: loadData
		};
	};

	return helper;
});
