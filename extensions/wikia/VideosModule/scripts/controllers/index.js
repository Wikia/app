/**
 * Controller/entry point for Videos Module
 */
require([
	'videosmodule.views.bottomModule',
	'videosmodule.views.rail',
	'videosmodule.models.videos'
], function (BottomModule, RailModule, VideoData) {
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
	function onWikiaRailLoad() {
		return new RailModule({
			el: document.getElementById('videosModule'),
			model: new VideoData()
		});
	}
	$(function () {
		$('#WikiaRail').on('afterLoad.rail', onWikiaRailLoad);
		view = new BottomModule({
			el: document.getElementById('RelatedPagesModuleWrapper'),
			model: new VideoData()
		});
		track();
	});
});
