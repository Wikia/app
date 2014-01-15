define( 'views.videopageadmin.categoryforms', [
		'jquery',
		'views.videopageadmin.autocomplete',
		'views.videopageadmin.carousel',
		'collections.videopageadmin.categorydata'
	], function( $, AutocompleteView, AdminCarouselView, CategoryDataCollection ) {
		'use strict';

		var FormGroupView = Backbone.View.extend( {
				initialize: function( props ) {
					this.categories = props.categories;
					this.categoryData = new CategoryDataCollection();
					this.autocomplete = new AutocompleteView( {
							el: this.el,
							collection: this.categories
					} );
					this.previewView = new AdminCarouselView( {
						el: this.$el.next( '.carousel' ),
						collection: this.categoryData
					} );
					_.bindAll( this, 'getPreview' );

					if ( this.categories.selectedCategory ) {
						this.getPreview();
					}
				},
				events: {
					'click .search-button': 'getPreview'
				},
				getPreview: function() {
					if ( !this.categories.selectedCategory ) {
						return window.alert( 'Please select a category before searching for results' );
					}

					this.categoryData.setCategory( this.categories.selectedCategory );
					return false;
				}
		} );

		return FormGroupView;
} );
