define( 'videosmodule.views.bottomModule', [
	'sloth',
	'videosmodule.views.titleThumbnail',
	'wikia.mustache',
	'videosmodule.templates.mustache',
	'videosmodule.models.abTestBottom',
	'wikia.tracker'
], function( sloth, TitleThumbnailView, Mustache, templates, abTest, Tracker ) {
	'use strict';

	// Keep AB test variables private
	var testCase,
		groupParams,
		track;

	track = Tracker.buildTrackingFunction({
		category: 'videos-module-bottom',
		trackingMethod: 'ga',
		action: Tracker.ACTIONS.IMPRESSION,
		label: 'module-impression'
	});

	testCase = abTest();
	groupParams = testCase.getGroupParams();

	function VideoModule( options ) {
		// Note that this.el refers to the DOM element that the videos module should be inserted before or after,
		// not the wrapper for the videos module. We can update this after the A/B testing is over.
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
		var i,
			$out,
			videos = this.model.data.videos,
			len = videos.length,
			thumbHtml = [];

		// AB test set rows shown
		videos = videos.slice( 0, groupParams.rows > 1 ? 8 : 4 );

		for ( i = 0; i < len; i++ ) {
			thumbHtml.push( new TitleThumbnailView( {
				el: 'li',
				model: videos[i],
				idx: i
			} ).render().$el );
		}

		$out = $( Mustache.render( templates.bottomModule, {
			title: $.msg( 'videosmodule-title-default' )
		} ) );

		$out.find( '.thumbnails' ).append( thumbHtml );

		if ( groupParams.position === 1 ) {
			this.$el.after( $out );
		} else {
			this.$el.before( $out );
		}
		this.$el.find( '.videos-module' ).addClass( groupParams.rows > 1 ? 'rows-2' : 'rows-1' );
		track();
	};

	return VideoModule;
} );
