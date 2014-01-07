define( 'collections.videohomepage.categorycarousel', [
	'models.videohomepage.categorythumb'
], function( CategoryThumbModel ) {
	'use strict';

	var CategoryCarouselCollection = Backbone.Collection.extend({
		model: CategoryThumbModel
	});

	return CategoryCarouselCollection;
});
