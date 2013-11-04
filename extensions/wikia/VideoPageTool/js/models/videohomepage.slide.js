define( 'models.videohomepage.slide', [], function() {
		'use strict';
		var FeaturedSlideModel = Backbone.Model.extend({
				defaults: {
					videoKey: String,
					embedData: null
				}
		});

		return FeaturedSlideModel;
});
