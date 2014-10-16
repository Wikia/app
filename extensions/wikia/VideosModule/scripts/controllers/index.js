/**
 * Controller/entry point for Videos Module
 * Note: There's some commented code that would instantiate the videos module at the bottom of that page. We're going
 * to leave this in there for now as we may at some point switch back to the bottom position.
 */
require([
	'videosmodule.views.rail',
	'videosmodule.models.videos',
	'bucky'
], function (RailModule, VideoData, bucky) {
	'use strict';

	var $rail = $('#WikiaRail');

	bucky = bucky('videosmodule.controller.index');

	function init() {
		var rail;

		bucky.timer.start('execution');
		// instantiate rail view
		rail = new RailModule({
			$el: $('#videosModule'),
			model: new VideoData(),
			isFluid: false
		});

		rail.$el.on('initialized.videosModule', function () {
			bucky.timer.stop('execution');
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
