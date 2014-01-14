define( 'views.videopageadmin.categoryforms', [
		'jquery',
		'views.videopageadmin.autocomplete',
		'views.videopageadmin.categorypreview',
		'collections.videopageadmin.categorydata'
	], function( $, AutocompleteView, CategoryPreviewView, CategoryDataCollection ) {
		'use strict';

		var FormGroupView = Backbone.View.extend( {
				initialize: function( props ) {
					this.categories = props.categories;
					this.categoryData = new CategoryDataCollection();
					this.autocomplete = new AutocompleteView( {
							el: this.el,
							collection: this.categories
					} );
					this.previewView = new CategoryPreviewView( {
						el: this.el,
						collection: this.categoryData
					} );
					_.bindAll( this, 'getPreview' );
				},
				events: {
					'click .search-button': 'getPreview'
				},
				getPreview: function( evt ) {
					evt.preventDefault();

					if ( !this.categories.selectedCategory ) {
						return window.alert( 'Please select a category before searching for results' );
					}

					this.categoryData.setCategory( this.categories.selectedCategory );
				}
		} );

		return FormGroupView;
} );
