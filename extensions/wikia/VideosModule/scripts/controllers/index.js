/**
 * Controller/entry point for Videos Module
 */
require([
	'videosmodule.views.rail',
	'videosmodule.models.videos'
], function (RailModule, VideoData) {
	'use strict';
	// instantiate bottom view
	function onWikiaRailLoad() {
		return new RailModule({
			el: document.getElementById('videosModule'),
			model: new VideoData()
		});
	}
	$(function () {
		$('#WikiaRail').on('afterLoad.rail', onWikiaRailLoad);
	});
});
