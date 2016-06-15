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
			var deferred = $.Deferred();

			if (!window.$p) { return deferred.resolve(formatData(mock)).promise(); }

			// Callback renders and injects results into the placeholder.
			$p('register', {
				max: options.count,
				widget: options.widget,
				callback: function(response) {
					console.log(response);
					// deferred.resolve(formatData(response));
				}
			});

			// Executes the registered call.
			$p('fetch');

			/*
			$p('register', {
                  max: 5,
                  widget: 'fandom-rec', // name of widget
                  opts: {resultType: "fandom"},
                  callback: function(resp) {
                  	console.log("// FANDOM WIDGET.");
                    console.log(resp);

                  }
               }
			);

			$p('register', {
                  max: 5,
                  widget: 'in-wikia', // name of widget
                  opts: {resultType: "fandom"},
                  callback: function(resp) {
                  	console.log("// IN WIKIA.");
                    console.log(resp);

                  }
               }
			);
			// Execute the registered call.
			$p('fetch');
			*/

			return deferred.promise();
		}

		function formatData(data) {
			var items = [];

			$.each(data.items, function(index, item) {
				if (items.length < options.count) {
					item.index = index;
					items.push(item);
				}
			});

			return {
				title: 'Top Links',
				items: items
			};
		}

		return {
			loadData: loadData
		}
	}
});
