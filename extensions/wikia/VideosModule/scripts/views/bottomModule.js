define( 'videosmodule.views.bottommodule', [
	'sloth',
	'thumbnails.views.titlethumbnail',
	'wikia.mustache',
	'videosmodule.templates.mustache'
], function( sloth, TitleThumbnailView, Mustache, templates ) {
	'use strict';

	// AB Test Code
	var testParams,
		testGroup,
		groups,
		groupParams;

	testParams = window.Wikia.AbTest;
	testParams.getGroup = function() {
		return 'GROUP_E';
	};
	testGroup = testParams ? testParams.getGroup( 'VIDEOS_MODULE_BOTTOM' ) : null;

	/*
	 * AB Test Info:
	 * Position 1: Below Read More
	 * Position 2: Above Read More
	 */

	groups = {
		// Article, Above Read More, 2 Rows
		'GROUP_A': {
			verticalOnly: false,
			position: 2,
			rows: 2
		},
		// Vertical, Above Read More, 2 Rows
		'GROUP_B': {
			verticalOnly: true,
			position: 2,
			rows: 2
		},
		// Article, Below Read More, 2 Rows
		'GROUP_C': {
			verticalOnly: false,
			position: 1,
			rows: 2
		},
		// Article, Above Read More, 2 Rows
		'GROUP_D': {
			verticalOnly: false,
			position: 2,
			rows: 2
		},
		// Article, Above Read More, 1 Row
		'GROUP_E': {
			verticalOnly: false,
			position: 2,
			rows: 1
		},
		// Article, Above Read More, 1 Row
		'GROUP_F': {
			verticalOnly: true,
			position: 2,
			rows: 1
		},
		// Article, Below Read More, 1 Row
		'GROUP_G': {
			verticalOnly: false,
			position: 1,
			rows: 1
		},
		// Article, Above Read More, 1 Row
		'GROUP_H': {
			verticalOnly: false,
			position: 2,
			rows: 1
		},
	};

	groupParams = groups[ testGroup || 'GROUP_G' ];

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
		if ( !groupParams ) {
			// Add tracking for GROUP_I, Control Group
			return false;
		}
		this.model.fetch( groupParams.verticalOnly );
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

		// AB test set rows shown
		videos = videos.slice( 0, groupParams.rows > 1 ? 8 : 4 );

		for ( i = 0; i < len; i++ ) {
			thumbHtml += new TitleThumbnailView( videos[i], { el: 'li' } ).render().el.outerHTML;
		}

		// TODO: hard coded title
		out = Mustache.render( templates.bottomModule, { title: 'Must Watch Videos', thumbnails: thumbHtml } );
		if ( groupParams.position === 1 ) {
			this.$el.append( out );
		} else {
			$( out ).insertBefore( this.$el.find( '.RelatedPagesModule' ) );
		}
		this.$el.find( '.videos-module' ).addClass( groupParams.rows > 1 ? 'rows-2' : 'rows-1' );
	};

	return VideoModule;

} );
