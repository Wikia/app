/**
 * View for carousel wrapper.  Data is category display title and thumbs list
 */
define('videohomepage.views.carousel', [
	'videopageadmin.collections.categorydata',
	'videohomepage.views.carouselThumb',
	'shared.views.owlcarousel',
	'videopagetool.templates.mustache',
	'wikia.tracker'
], function (
	CategoryDataCollection,
	CarouselThumbView,
	OwlCarouselBase,
	templates,
	Tracker
) {
	'use strict';

	var CarouselView,
		track;

	track = Tracker.buildTrackingFunction({
		category: 'video-home-page',
		trackingMethod: 'analytics',
	});

	CarouselView = OwlCarouselBase.extend({
		initialize: function () {
			var total = parseInt(this.model.get('total'), 10);
			this.modulePosition = this.model.collection.indexOf(this.model);
			this.collection = new CategoryDataCollection(this.model.get('thumbnails')
				.slice(0, 24));
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
		events: {
			'click .owl-next, .owl-prev': 'onArrowClick',
			'click .owl-page': 'onPaginationClick'
		},
		template: Mustache.compile(templates.carousel),
		render: function () {
			var self = this;

			this.$el.html(this.template(this.model.toJSON()));
			this.$carousel = this.$el.find('.category-carousel');

			this.collection.each(function (categoryData) {
				var view = new CarouselThumbView({
					model: categoryData,
					modulePosition: self.modulePosition
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
					self.$carousel.find('.title a')
						.ellipses({
							wordsHidden: 2
						});
				},
				afterAction: function () {
					self.resizeLastSlide();
				}
			});

			track({
				label: 'category-carousel',
				value: this.modulePosition,
				action: Tracker.ACTIONS.IMPRESSION
			});

			return this;
		},
		/**
		 * onArrowClick
		 * @description Handler for when category carousel arrow buttons are clicked
		 * @param evt jQuery event object
		 */
		onArrowClick: function (evt) {
			track({
				label: 'category-carousel-arrow',
				// 0 is a left arrow click
				// 1 is a right arrow click
				value: $(evt.target).hasClass('owl-next') ? 1 : 0,
				action: Tracker.ACTIONS.CLICK
			});
		},
		/**
		 * onPaginationClick
		 * @description Handler for when pagination dots are clicked
		 * @param evt jQuery event object
		 * @return
		 */
		onPaginationClick: function (evt) {
			track({
				label: 'category-carousel-pagination',
				// The target page clicked
				value: Array.prototype.indexOf.call(this.$('.owl-pagination')[0].children, evt.target),
				action: Tracker.ACTIONS.CLICK
			});
		},
		/**
		 * @description Method to handle repositioning & resizing of elements based on fluid repaints
		 */
		resizeLastSlide: function () {
			var height,
				$buttons;

			$buttons = this.$('.owl-buttons div');
			height = this.$('.owl-item')
				.eq(0)
				.find('img')
				.height();

			// set the last slides height ( since it doesn't come with an image )
			this.$('.category-slide')
				.height(height)
				.show();

			// position slider arrows in correct position
			$buttons.css({
				top: (height / 2),
				marginTop: -Math.round($buttons.eq(0)
					.height() / 2)
			});
		}
	});

	return CarouselView;
});
