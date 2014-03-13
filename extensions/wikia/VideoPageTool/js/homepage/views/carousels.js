/**
 * View for list of carousels on the video homage page.
 * Collection data is an array with all the carousel data.
 */
define('videohomepage.views.carousels', [
	'videopageadmin.collections.categorydata',
	'videohomepage.views.carousel'
], function (CategoriesCollection, CarouselView) {
	'use strict';

	var CarouselsView = Backbone.View.extend({
		initialize: function () {
			// data from collection is assigned on page load in the category template
			this.collection = new CategoriesCollection(Wikia.modules.videoHomePage.categoryData);
			this.render();
		},
		render: function () {
			var that = this;

			this.collection.each(function (carouselData) {
				var carouselView = new CarouselView({
					model: carouselData // data includes carousel title and list of thumbs
				});

				// append carousel wrapper DOM to home page
				that.$el.append(carouselView.$el);
			});

			return this;
		}
	});

	return CarouselsView;
});
