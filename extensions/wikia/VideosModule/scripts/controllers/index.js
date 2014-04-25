/**
 * Controller/entry point for Videos Module
 */
require([
	'videosmodule.views.bottomModule',
	'videosmodule.views.rail',
	'videosmodule.models.videos',
	'wikia.tracker',
	'sloth'
], function (BottomModule, RailModule, VideoData, Tracker, sloth) {
	'use strict';
	var view, track;

	track = Tracker.buildTrackingFunction({
		category: 'videos-module-bottom',
		trackingMethod: 'both',
		action: Tracker.ACTIONS.IMPRESSION,
		label: 'bottom-of-page-impression'
	});

	// instantiate rail view
	function onWikiaRailLoad() {
		return new RailModule({
			el: document.getElementById('videosModule'),
			model: new VideoData(),
			isFluid: false
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
		// Append div to end of wikia article to give a consistent element to key off of
		$('#WikiaArticle').after('<div id="PlaceHolderVMB"></div>');
		// Track how many impressions we'd get for the videos module in the bottom position, including
		// pages without a read more section.
		sloth({
			on: document.getElementById('PlaceHolderVMB'),
			threshold: 0,
			callback: function () {
				track();
			}
		});

	});
});
