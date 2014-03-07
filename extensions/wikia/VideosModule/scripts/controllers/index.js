/**
 * Controller/entry point for Videos Module
 */
require([
	'videosmodule.views.bottomModule',
	'videosmodule.views.rail',
	'videosmodule.models.videos',
	'wikia.tracker'
], function (BottomModule, RailModule, VideoData, Tracker) {
	'use strict';
	var view,
		track;

	track = Tracker.buildTrackingFunction({
		trackingMethod: 'both',
		action: Tracker.ACTIONS.IMPRESSION,
		label: 'valid-code'
	});
	// instantiate rail view
	function onWikiaRailLoad() {
		return new RailModule({
			el: document.getElementById('videosModule'),
			model: new VideoData()
		});
	}
	$(function () {
		if (window.wgVideosModuleABTest === 'rail') {
			$('#WikiaRail').on('afterLoad.rail', onWikiaRailLoad);
		} else {
			view = new BottomModule({
				el: document.getElementById('RelatedPagesModuleWrapper'),
				model: new VideoData()
			});
		}
		track({
			category: 'videos-module-' + window.wgVideosModuleABTest
		});
	});
});
