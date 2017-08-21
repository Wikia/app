define('ext.wikia.recirculation.helpers.liftigniter', [
	'jquery',
	'wikia.window',
	'wikia.thumbnailer'
], function ($, w, thumbnailer) {
	'use strict';

	var willFetch = {},
		fetchQueue = [],
		fetching = false;

	var prepare = function (options) {

		var deferred = $.Deferred(),
			registerOptions = {
				max: options.max,
				widget: options.widget,
				callback: function (response) {
					resizeThumbnails(response, options);
                    deferred.resolve(response);
                    fetching = false;
					if(fetchQueue.length) {
						// setTimeout is necessary because LI need to wait for LI to remove already registered modules
						// LI clear register modules just after running all callbacks
						setTimeout(function () {
							fetch(fetchQueue.shift());
						});
					}
				}
			};

		if (!w.$p) {
			return deferred.reject('Liftigniter library not found').promise();
		}

		if (options.opts) {
			registerOptions.opts = options.opts;
		}

		var module = {
			promise: deferred,
			options: registerOptions
		};

		if(willFetch[options.modelName]) {
			willFetch[options.modelName].push(module)
		} else {
			willFetch[options.modelName] = [module];
		}

		return deferred.promise();
		// TODO setup tracking
		//
		// function setupTracking() {
		// 	var elements = $('.recirculation-unit .item[data-meta="' + options.widget + '"]').get(),
		// 		trackOptions = {
		// 			elements: elements,
		// 			name: options.widget,
		// 			source: 'LI'
		// 		};
		//
		// 	if (options.opts) {
		// 		trackOptions.opts = options.opts;
		// 	}
		// 	w.$p('track', trackOptions);
		// }
		// return {
		// 	setupTracking: setupTracking,
		// 	loadData: loadData
		// };
	};

	function resizeThumbnails(data, options) {
		$.each(data.items, function (index, item) {
			if (thumbnailer.isThumbUrl(item.thumbnail)) {
				item.thumbnail = thumbnailer.getThumbURL(item.thumbnail, 'image', options.width, options.height);
			}
		});
	}

	function fetch(modelName) {
		if (willFetch[modelName] && !fetching) {
			willFetch[modelName].forEach(function (module) {
				w.$p('register', module.options);
			});
			fetching = true;
			w.$p('fetch');
		} else if (fetching) {
			fetchQueue.push(modelName);
		}
	}

	return {
		prepare: prepare,
		fetch: fetch
	};
});
