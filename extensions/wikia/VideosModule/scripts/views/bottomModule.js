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
		this.$el = $( options.el );
		this.data = null;
		this.articleId = window.wgArticleId;

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
			$.when( this.getData() )
				.done( $.proxy( this.renderWidthData, this ) );
		},
		renderWidthData: function() {
			var i, out,
				videos = this.data.videos,
				len = videos.length,
				thumbHtml = '';

			for ( i = 0; i < len; i++ ) {
				thumbHtml += new TitleThumbnailView( videos[i] ).render();
			}

			// TODO: hard coded title
			out = Mustache.render( templates.bottomModule, { title: 'Must Watch Videos', thumbnails: thumbHtml } );
			this.$el.append( out );
		},
		getData: function () {
			var self = this;
			if ( this.data !== null ) {
				return this.data;
			} else {
				return nirvana.getJson(
					'VideosModuleController',
					'index',
					{ articleId: this.articleId }
				)
					.done( function( data ) {
						self.data = data;
					} );
			}
		}
	};

	$( function() {
		var module = new VideoModule( { el: document.getElementById( 'WikiaArticleFooter' ) } );
	} );

} );