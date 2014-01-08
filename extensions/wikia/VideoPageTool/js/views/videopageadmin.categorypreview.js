/**
 * @name CategoryPreviewView
 * @description Backbone subview/module for carousel preview of video thumbnails from a specific category
 */
define( 'views.videopageadmin.categorypreview', [
		'jquery',
		'views.videopageadmin.categorypreviewitem'
	], function( $, CategoryPreviewItem ) {
	'use strict';
	var CategoryPreviewView = Backbone.View.extend( {
		initialize: function() {
			_.bindAll( this, 'render' );
			console.log( this.collection );
			this.collection.on( 'reset', this.render );
		},
		events: {
		},
		render: function() {
			this.collection.each(function( categoryItem ) {
				console.log( categoryItem );
			} );
			return this;
		}
	} );

	return CategoryPreviewView;
} );
