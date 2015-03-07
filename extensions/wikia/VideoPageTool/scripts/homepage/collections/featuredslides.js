define('videohomepage.collections.featuredslides', [], function () {
	'use strict';

	var SlideCollection = Backbone.Collection.extend({
		resetEmbedData: function () {
			_.each(this.models, function (e) {
				e.set({
					embedData: null
				});
			});
		}
	});

	return SlideCollection;
});
