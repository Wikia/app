define( 'views.videopageadmin.categoryforms', [
		'jquery',
		'views.videopageadmin.autocomplete',
		'views.videopageadmin.categorypreview',
		'collections.videopageadmin.category',
		'collections.videopageadmin.categorydata'
	], function( $, AutocompleteView, CategoryPreviewView, CategoryCollection, CategoryDataCollection ) {
		'use strict';

		var FormGroupView = Backbone.View.extend({
				initialize: function() {
					this.categories = new CategoryCollection();
					this.categoryData = new CategoryDataCollection();
					this.autocomplete = new AutocompleteView({
							el: this.el,
							collection: this.categories
					} );
					this.previewView = new CategoryPreviewView({
						el: this.el,
						collection: this.categoryData
					} );
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

					this.categoryData.setCategory( this.categories.selectedCategory );
				}
		} );

		return FormGroupView;
} );
