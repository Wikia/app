/**
 * Bootstrapping code for executing JS that's created by jWPlayer.class.php
 * @todo move JS from PHP to this file
 * @see http://www.longtailvideo.com/support/jw5/31164/javascript-api-reference
 */

define('wikia.videohandler.jwplayer', ['wikia.window'], function jwplayer(window) {
	/**
	 * Set up JWPlayer and tracking events
	 * @param {Object} params Player params sent from the video handler
	 * @param {VideoBootstrap} vb Instance of video player
	 */
	return function(params, vb) {
		var doc = window.document,
			script = doc.createElement('script');

		script.type = 'text/javascript';
		script.text = params.jwScript;

		var head = doc.head || doc.getElementsByTagName('head')[0];
		head.appendChild(script);

		/**
		 * For now, just track that the player was initiated and call that a view
		 * @todo implement actual event based tracking.
		 */
		if(vb) {
			vb.timeoutTrack();
		}
	}
});