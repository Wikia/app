/**
 * Controller/entry point for Videos Module
 * Note: There's some commented code that would instantiate the videos module at the bottom of that page. We're going
 * to leave this in there for now as we may at some point switch back to the bottom position.
 */
require([
	'videosmodule.views.rail',
	'videosmodule.models.videos'
], function (RailModule, VideoData) {
	'use strict';

	var $rail = $('#WikiaRail');

	function init() {
		// instantiate rail view
		return new RailModule({
			el: document.getElementById('videosModule'),
			model: new VideoData(),
			isFluid: false
		});
	}

	$(function () {
		// check if right rail is loaded before initing. If it's not loaded, bind to load event.
		if ($rail.hasClass('loaded')) {
			init();
		} else {
			$rail.on('afterLoad.rail', init);
		}
	});
});
