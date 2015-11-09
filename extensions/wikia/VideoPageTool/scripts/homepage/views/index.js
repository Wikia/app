/**
 * view for video home page
 */
(function () {
	'use strict';

	var FeaturedVideoView = require('videohomepage.views.feature'),
		SearchView = require('videohomepage.views.search'),
		CarouselsView = require('videohomepage.views.carousels');

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
})();
