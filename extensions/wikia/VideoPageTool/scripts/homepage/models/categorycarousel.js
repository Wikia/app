define('videohomepage.models.categorycarousel', [], function () {
	'use strict';
	var CategoryCarouselModel = Backbone.Model.extend({
		defaults: {
			displayTitle: String
		}
	});

	return CategoryCarouselModel;
});
