/**
 * Controller/entry point for Videos Module
 */
require([
	'videosmodule.views.bottomModule',
	'videosmodule.models.videos',
	'wikia.tracker'
], function (BottomModule, VideoData, Tracker) {
	'use strict';
	var view,
		track;

	track = Tracker.buildTrackingFunction({
		category: 'videos-module-bottom',
		trackingMethod: 'both',
		action: Tracker.ACTIONS.IMPRESSION,
		label: 'valid-code'
	});

	// instantiate bottom view
	$(function () {
		view = new BottomModule({
			el: document.getElementById('RelatedPagesModuleWrapper'),
			model: new VideoData()
		});
		track();
	});
});
