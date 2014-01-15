define( 'views.videopageadmin.categoryforms', [
		'jquery',
		'views.videopageadmin.autocomplete',
		'views.videopageadmin.carousel',
		'collections.videopageadmin.categorydata'
	], function( $, AutocompleteView, AdminCarouselView, CategoryDataCollection ) {
		'use strict';

		var FormGroupView = Backbone.View.extend( {
				initialize: function( props ) {
					var self = this;
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
					_.bindAll( this,
						'getPreview',
						'togglePreview',
						'onCategoryDataReset'
					);

					if ( this.categories.selectedCategory ) {
						this.getPreview();
					}

					/**
					 * TODO: fix the dom structure so you can use a scoped selector in
					 * the events hash as opposed to selecting OUTSIDE of the scope of this.
					 * .preview and .carousel should not be siblings to .form-box orrrrrr
					 * they should all be wrapped by a higher level element and that should
					 * be the parent of this view.
					 */
					this.$el.nextAll( '.preview' ).eq( 0 ).click( function() {
						self.togglePreview();
						return false;
					} );

					this.categoryData.on( 'reset', this.onCategoryDataReset );
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
				},
				onCategoryDataReset: function() {
					// Reset selected category to nothing on collection wipes
					if ( !this.categoryData.length ) {
						this.categories.selectedCategory = null;
					}
				},
				togglePreview: function() {
					this.previewView.$el.slideToggle( 200 );
					return false;
				}
		} );

		return FormGroupView;
} );
