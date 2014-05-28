/**
 * Controller/entry point for Videos Module
 * Note: There's some commented code that would instantiate the videos module at the bottom of that page. We're going
 * to leave this in there for now as we may at some point switch back to the bottom position.
 */
require([
	//'videosmodule.views.bottomModule',
	'videosmodule.views.rail',
	'videosmodule.models.videos'
], function (/*BottomModule,*/ RailModule, VideoData) {
	'use strict';

	$(function () {
		// instantiate rail view
		$('#WikiaRail').on('afterLoad.rail', function() {
			return new RailModule({
				el: document.getElementById('videosModule'),
				model: new VideoData(),
				isFluid: false
			});
		});

		/*
		view = new BottomModule({
			el: document.getElementById('RelatedPagesModuleWrapper'),
			model: new VideoData()
		});*/
	});
});
