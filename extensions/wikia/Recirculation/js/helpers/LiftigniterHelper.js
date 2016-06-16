/*global define*/
define('ext.wikia.recirculation.helpers.liftigniter', [
	'jquery'
], function ($) {

	return function(config) {
		var defaults = {
				count: 5
			},
			options = $.extend({}, defaults, config);

		function loadData() {
			if (!window.$p) { return deferred.reject('Liftigniter library not found').promise(); }

			var deferred = $.Deferred(),
				registerOptions = {
					max: options.count,
					widget: options.widget,
					callback: function(response) {
						deferred.resolve(formatData(response));
					}
				};

			if (options.widget === 'fandom-rec') {
				registerOptions.opts = {resultType: "fandom"}
			}

			// Callback renders and injects results into the placeholder.
			$p('register', registerOptions);

			// Executes the registered call.
			$p('fetch');

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
				if (items.length < options.count) {
					item.index = index;
					item.title = item.title.replace(' - Fandom - Powered by Wikia', '');
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
			$p('track', trackOptions);
		}

		return {
			setupTracking: setupTracking,
			loadData: loadData
		}
	}
});
