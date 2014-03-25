/**
 * View for carousel wrapper.  Data is category display title and thumbs list
 */
define('videopageadmin.views.carousel', [
	'shared.views.owlcarousel',
	'shared.views.carouselThumb',
	'videopagetool.templates.mustache'
], function (
	OwlCarouselView,
	CarouselThumbView,
	templates
) {
	'use strict';

	var AdminCarouselView = OwlCarouselView.extend({
		initialize: function () {
			_.bindAll(this,
				'render',
				'onReset'
			);
			this.collection.on('reset', this.render);
			this.currentPage = 1;

			// bind events outside the scope of this view
			this.$el
				.closest('.vpt-form')
				.on('form:reset', this.onReset);
		},
		template: Mustache.compile(templates.adminCarousel),
		events: {
			'click .owl-buttons div': 'onPageChange'
		},
		render: function () {
			var self;

			if (!this.collection.length) {
				this.$el.html('');
				return this;
			}

			self = this;

			this.pageCount = Math.ceil(this.collection.length / 3);
			this.$el.html(this.template({
				pages: this.pageCount,
				total: this.collection.response.total
			}));
			this.$carousel = this.$el.find('.category-carousel');

			this.collection.each(function (categoryData) {
				var view = new CarouselThumbView({
					model: categoryData
				});
				self.$carousel.append(view.$el);
			});

			this.renderCarousel({
				items: 3,
				lazyLoad: false,
				navigation: true,
				pagination: false
			});
			this.$el.slideDown(100);

			return this;
		},
		onReset: function () {
			this.$el.slideUp(200);
			this.collection.selectedCategory = '';
			this.collection.reset();
		},
		onPageChange: function (evt) {
			var $el = $(evt.target);

			if ($el.hasClass('owl-next') && this.currentPage < this.pageCount) {
				this.currentPage++;
			} else {
				this.currentPage--;
			}
			this.$('.results-page-current').text(this.currentPage);
		}
	});
	return AdminCarouselView;
});
