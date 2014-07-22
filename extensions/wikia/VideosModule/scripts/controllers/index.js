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
		return new RailModule({
			el: document.getElementById('videosModule'),
			model: new VideoData(),
			isFluid: false
		});
	}

	$(function () {
		// instantiate rail view
		if ($rail.hasClass('loaded')) {
			Wikia.syslog(Wikia.log.levels.debug, 'VideosModule', {railLoaded: true});
			init();
		} else {
			Wikia.syslog(Wikia.log.levels.debug, 'VideosModule', {railLoaded: false});
			$rail.on('afterLoad.rail', init);
		}
	});
});
