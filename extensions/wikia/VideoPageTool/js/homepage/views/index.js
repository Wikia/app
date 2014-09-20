/**
 * view for video home page
 */
require([
	'videohomepage.views.featured',
	'videohomepage.views.search',
	'videohomepage.views.carousels'
], function (FeaturedVideoView, SearchView, CarouselsView) {

	'use strict';

	// mock a global object in lieu of having one already
	window.Wikia.modules = window.Wikia.modules || {};
	window.Wikia.modules.videoHomePage = window.Wikia.modules.videoHomePage || {};

	function init() {
		var module = window.Wikia.modules.videoHomePage;
		module.search = new SearchView();

		module.featured = new FeaturedVideoView({
			el: '#featured-video-slider',
			$bxSlider: $('#featured-video-bxslider'),
			$thumbs: $('#featured-video-thumbs')
		});

		module.categories = new CarouselsView({
			el: '.latest-videos-wrapper'
		});
	}

	$(init);

});
