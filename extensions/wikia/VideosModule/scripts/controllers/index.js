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
			// Debugging to see if there's a race condition. This fires if there's a bug. (VID-1769)
			Wikia.syslog(Wikia.log.levels.debug, 'VideosModule', {railLoaded: true, adsShown: !!window.wgShowAds});
			init();
		} else {
			$rail.on('afterLoad.rail', init);
		}
	});
});
