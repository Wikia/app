define('wikia.videohandler.anyclip', ['wikia.window'], function Anyclip(window) {
	'use strict';

	/**
	 * Set up AnyClip player and tracking events
	 * @param {Object} params Player params sent from the video handler
	 * @param {VideoBootstrap} vb Instance of video player
	 */
	return function (params, vb) {
		window.AnyClipPlayer.load(['#'+params.playerId, {clipID:params.videoId, autoPlay:params.autoPlay}, {wmode: "opaque"}]);

		/**
		 * For now, just track that the player was initiated and call that a view
		 * @todo implement actual event based tracking.
		 */
		if(vb) {
			vb.timeoutTrack();
		}
	}
});