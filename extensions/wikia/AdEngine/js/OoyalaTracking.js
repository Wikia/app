alert('loaded');
require( ['wikia.window', 'wikia.tracker'], function( window, tracker ) {
	var wikia = window.Wikia = window.Wikia || {};

	/**
	 * Add ability to tracking video views inside flite
	 * @param {String} video Identifier for video, either title or id
	 */
	wikia.fliteOoyalaTracker = function( video ) {
		tracker.track({
			action: 'content-begin',
			category: 'video-player-stats',
			label: 'ooyala',
			trackingMethod: 'internal',
			title: video,
			clickSource: 'ad'
		});
	};
});