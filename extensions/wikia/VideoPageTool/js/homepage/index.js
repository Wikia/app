/**
 * @description A pseudo router/controller used to instantiate Backbone views and centralize the logic for module
 * instantiation. Normally would be handled with an instance of Backone.Router, but this approach
 * is avoided since we aren't doing any client-side routing at this point ( though we should :D )
 */
require( [
	'videohomepage.views.featured',
	'videohomepage.views.search',
	'videohomepage.views.carousels'
], function( FeaturedVideoView, SearchView, CarouselsView ) {

	'use strict';

	/*
	 * mock a global object in lieu of having one already
	 * TODO: this should be replaced with a more terse implementation once we have invested
	 * in better application-wide namespacing and tools
	 */
	window.Wikia.modules = window.Wikia.modules || {};
	window.Wikia.modules.videoHomePage = window.Wikia.modules.videoHomePage || {};

	function init() {
		var module = window.Wikia.modules.videoHomePage;
		module.search = new SearchView();

		module.featured = new FeaturedVideoView( {
			el: '#featured-video-slider',
			$bxSlider: $( '#featured-video-bxslider' ),
			$thumbs: $( '#featured-video-thumbs' )
		} );

		module.categories = new CarouselsView( {
			el: '.latest-videos-wrapper'
		} );
	}

	$( init );

} );


