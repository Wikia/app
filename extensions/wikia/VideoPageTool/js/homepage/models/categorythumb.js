define('videohomepage.models.categorythumb', [], function () {
	'use strict';
	var CategoryThumbModel = Backbone.Model.extend({
		defaults: {
			videoThumb: String,
			videoTitle: String
		}
	});

	return CategoryThumbModel;
});
