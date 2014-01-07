define( 'views.videopageadmin.categoryforms', [
		'jquery',
		'views.videopageadmin.autocomplete',
		'collections.videopageadmin.category',
		'collections.videopageadmin.categorydata'
	], function( $, AutocompleteView, CategoryCollection, CategoryDataCollection ) {
		'use strict';

		var FormGroupView = Backbone.View.extend({
				initialize: function() {
					this.categories = new CategoryCollection();
					this.categoryData = new CategoryDataCollection();
					this.autocomplete = new AutocompleteView({
							el: this.el,
							collection: this.categories
					});
					_.bindAll( this, 'getPreview' );
					console.log( this.$el );
				},
				events: {
					'click .search-button': 'getPreview'
				},
				getPreview: function( evt ) {
					evt.preventDefault();

					if ( !this.categories.selectedCategory ) {
						return alert( 'Please select a category before searching for results' );
					}

					this.categoryData.fetch({
						data: {
							categoryName: this.categories.selectedCategory
						}
					});
				}
		});

		return FormGroupView;
});
