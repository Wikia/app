define( 'videosmodule.views.bottommodule', [
	'sloth',
	'thumbnails.views.titlethumbnail',
	'wikia.mustache',
    'videosmodule.templates.mustache'
], function( sloth, TitleThumbnailView, Mustache, templates ) {
	'use strict';

	function VideoModule( options ) {
		this.el = options.el;
		this.$el = $( options.el );
		this.model = options.model;
		this.articleId = window.wgArticleId;

		// Make sure we're on an article page
		if ( this.articleId ) {
			this.init();
		}
	}

	VideoModule.prototype.init = function() {
		this.model.fetch();
		// Sloth is a lazy loading service that waits till an element is visisble to load more content
		sloth( {
			on: this.el,
			threshold: 200,
			callback: $.proxy( this.render, this )
		} );
	};

	VideoModule.prototype.render = function() {
		$.when( this.model.fetch() )
			.done( $.proxy( this.renderWithData, this ) );
	};

	VideoModule.prototype.renderWithData = function() {
		var i, out,
			videos = this.model.data.videos,
			len = videos.length,
			thumbHtml = '';

		for ( i = 0; i < len; i++ ) {
			thumbHtml += new TitleThumbnailView( videos[i], { el: 'li' } ).render().el.outerHTML;
		}

		out = Mustache.render( templates.bottomModule, {
			title: $.msg( 'videosmodule-title-must-watch' ),
			thumbnails: thumbHtml
		} );
		this.$el.append( out );
	};

	return VideoModule;

} );
