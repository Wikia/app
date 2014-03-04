/**
 * View for carousel wrapper.  Data is category display title and thumbs list
 */
define('videohomepage.views.carousel', [
	'videopageadmin.collections.categorydata',
	'shared.views.carouselthumb',
	'shared.views.owlcarousel',
	'videopagetool.templates.mustache',
	'jquery.ellipses'
], function (
	CategoryDataCollection,
	CarouselThumbView,
	OwlCarouselBase,
	templates
) {
	'use strict';

	var CarouselView = OwlCarouselBase.extend({
		initialize: function () {
			var total = parseInt(this.model.get('total'), 10);
			this.collection = new CategoryDataCollection(this.model.get('thumbnails').slice(0, 24));
			// if the category doesn't contain more than 24 videos, don't show seemore label
			if (total > 24) {
				this.collection.add({
					count: total,
					label: this.model.get('seeMoreLabel'),
					url: this.model.get('url'),
					type: 'redirect'
				});
			}
			this.render();
		},
		template: Mustache.compile(templates.carousel),
		render: function () {
			var self = this;

			this.$el.html(this.template(this.model.toJSON()));
			this.$carousel = this.$el.find('.category-carousel');

			this.collection.each(function (categoryData) {
				var view = new CarouselThumbView({
					model: categoryData
				});
				self.$carousel.append(view.$el);
			});

			this.renderCarousel({
				scrollPerPage: true,
				pagination: true,
				paginationSpeed: 800,
				slideSpeed: 800,
				lazyLoad: true,
				navigation: true,
				rewindNav: false,
				afterUpdate: function () {
					self.$carousel.find('.title a').ellipses({
						wordsHidden: 2
					});
					self.resizeLastSlide();
				},
				beforeUpdate: function () {
					self.$('.ellipses').remove();
				}
			});

			return this;
		},
		/**
		 * @description Method to handle repositioning & resizing of elements based on fluid repaints
		 */
		resizeLastSlide: function () {
			var height,
				$buttons;

			$buttons = this.$('.owl-buttons div');
			height = this.$('.owl-item').eq(0).find('img').height();

			// set the last slides height ( since it doesn't come with an image )
			this.$('.category-slide').height(height).show();

			// position slider arrows in correct position
			$buttons.css({
				top: (height / 2),
				marginTop: -Math.round($buttons.eq(0).height() / 2)
			});
		}
	});

	return CarouselView;
});
