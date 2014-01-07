/**
 * @name CategoryPreviewView
 * @description Backbone subview/module for carousel preview of video thumbnails from a specific category
 */
define( 'views.videopageadmin.categorypreview', [
		'jquery',
		'views.videopageadmin.categorypreviewitem'
	], function( $, CategoryPreviewItem ) {
	'use strict';
	var CategoryPreviewView = Backbone.View.extend({
		initialize: function() {
			_.bindAll( this, 'render' );
			this.collection.on( 'reset', this.render );
		},
		events: {
		},
		render: function() {
			return this;
		}
	});

	return CategoryPreviewView;
});
