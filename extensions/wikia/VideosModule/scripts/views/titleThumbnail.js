define( 'videosmodule.views.titlethumbnail', [
	'thumbnails.views.titlethumbnail',
], function( TitleThumbnail ) {
	'use strict';

	function VideosModuleThumbnail() {
		TitleThumbnail.apply( this, arguments );
	}

	VideosModuleThumbnail.prototype = Object.create( TitleThumbnail.prototype );
	VideosModuleThumbnail.prototype.bindEvents = function() {
		console.log( this.$el );
		this.$el.on( 'click', 'a', function( evt ) {
			evt.preventDefault();
			console.log( evt );
		});
	};
	VideosModuleThumbnail.prototype.render = function() {
		this.constructor.prototype.render.call( this );
		this.bindEvents();
		return this;
	};

	return VideosModuleThumbnail;
} );
