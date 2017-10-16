define('videopageadmin.views.categoryforms', [
	'jquery',
	'videopageadmin.views.autocomplete',
	'videopageadmin.views.carousel',
	'videopageadmin.collections.categorydata'
], function ($, AutocompleteView, AdminCarouselView, CategoryDataCollection) {
	'use strict';

	var FormGroupView = Backbone.View.extend({
		initialize: function (props) {
			var self = this;
			this.categories = props.categories;
			this.categoryData = new CategoryDataCollection();
			this.autocomplete = new AutocompleteView({
				el: this.el,
				collection: this.categories
			});
			this.previewView = new AdminCarouselView({
				el: this.$el.find('.carousel-wrapper'),
				collection: this.categoryData
			});
			_.bindAll(this,
				'getPreview',
				'togglePreview',
				'onCategoryDataReset'
			);

			if (this.categories.selectedCategory) {
				this.getPreview();
			}

			this.categoryData.on('reset', this.onCategoryDataReset);
		},
		events: {
			'click .search-button': 'getPreview',
			'click .preview': 'togglePreview'
		},
		getPreview: function () {
			if (!this.categories.selectedCategory) {
				return window.alert('Please select a category before searching for results');
			}

			this.categoryData.setCategory(this.categories.selectedCategory);
			return false;
		},
		onCategoryDataReset: function () {
			// Reset selected category to nothing on collection wipes
			if (!this.categoryData.length) {
				this.categories.selectedCategory = null;
			}
		},
		togglePreview: function () {
			this.previewView.$el.slideToggle(200);
			return false;
		}
	});

	return FormGroupView;
});
