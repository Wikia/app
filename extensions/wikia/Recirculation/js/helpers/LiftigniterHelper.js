/*global define*/
define('ext.wikia.recirculation.helpers.liftigniter', [
	'jquery'
], function ($) {

	return function(config) {
		var defaults = {
				count: 5
			},
			options = $.extend({}, defaults, config);

		var mock = {
		   "items":[
		      {
		         "title":"Far Harbor (add-on)",
		         "rank":"1",
		         "thumbnail":"http://vignette1.wikia.nocookie.net/fallout/images/d/db/Fallout_4_Far_Harbor_add-on_packaging.jpg/revision/latest?cb=20160216172224",
		         "url":"http://fallout.wikia.com/wiki/Far_Harbor_(add-on)"
		      },
		      {
		         "title":"Nuka-World (add-on)",
		         "url":"http://fallout.wikia.com/wiki/Nuka-World_(add-on)",
		         "thumbnail":"http://vignette3.wikia.nocookie.net/fallout/images/3/31/Fallout_4_Nuka-World_add-on_packaging.jpg/revision/latest?cb=20160613034942",
		         "rank":"2"
		      },
		      {
		         "url":"http://fallout.wikia.com/wiki/Fallout_4_weapons",
		         "rank":"3",
		         "title":"Fallout 4 weapons",
		         "thumbnail":"http://vignette4.wikia.nocookie.net/fallout/images/1/13/44_pistol.png/revision/latest?cb=20151122151117"
		      },
		      {
		         "thumbnail":"http://vignette1.wikia.nocookie.net/fallout/images/0/0b/Fallout_4_Vault-Tec_Workshop_add-on_packaging.jpg/revision/latest?cb=20160613034404",
		         "url":"http://fallout.wikia.com/wiki/Vault-Tec_Workshop",
		         "rank":"4",
		         "title":"Vault-Tec Workshop"
		      },
		      {
		         "url":"http://fallout.wikia.com/wiki/Contraptions_Workshop",
		         "title":"Contraptions Workshop",
		         "thumbnail":"http://vignette2.wikia.nocookie.net/fallout/images/0/05/Fallout_4_Contraptions_Workshop_add-on_packaging.jpg/revision/latest?cb=20160613033830",
		         "rank":"5"
		      }
		   ]
		};

		function loadData() {
			if (!window.$p) { return deferred.resolve(formatData(mock)).promise(); }

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
