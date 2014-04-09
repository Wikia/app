/**
 * Controller/entry point for Videos Module
 */
require([
	'videosmodule.views.bottomModule',
	'videosmodule.views.rail',
	'videosmodule.models.videos'
], function (BottomModule, RailModule, VideoData) {
	'use strict';
	var view;

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
	});
});
