require( [
	'sloth',
	'thumbnails.titlethumbnail',
	'wikia.nirvana',
	'wikia.mustache',
    'videosmodule.templates.mustache'
], function( sloth, TitleThumbnailView, nirvana, Mustache, templates ) {
	'use strict';

	function VideoModule( options ) {
		this.el = options.el;
		this.data = null;
		this.aritcleId = window.wgArticleId;
		this.template = Mustache.compile( templates.bottomModule );

		if ( !this.articleId ) {
			return;
		}
		this.init();
	}

	VideoModule.prototype = {
		init: function() {
			this.getData();
			sloth( {
				on: this.el,
				threshold: 200,
				callback: $.proxy( this.render, this )
			} );
		},
		render: function() {
			$.when( this.getData )
				.done( $.proxy( function() {

				}, this ) );

		},
		getData: function () {
			if ( this.data !== null ) {
				return this.data;
			} else {
				return nirvana.getJson(
					'VideosModuleController',
					'index',
					{
						articleId: this.articleId
					}
				);
			}
		}
	};

	$( function() {
		var module = new VideoModule( { el: document.getElementById( 'WikiaArticleFooter' ) } );
	} );

} );