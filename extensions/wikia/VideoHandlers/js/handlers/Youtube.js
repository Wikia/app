/**
 * Use Youtube's iframe API to play and track videos
 * Uses player events to track video views
 *
 * @see https://developers.google.com/youtube/iframe_api_reference
 */

define('wikia.videohandler.youtube', ['wikia.window', 'wikia.loader'], function Youtube(window, loader) {
	'use strict';

	/**
	 * Set up youtube player and tracking events
	 * @param {Object} params Player params sent from the video handler
	 * @param {VideoBootstrap} vb Instance of video player
	 */
	return function(params, vb) {
		var player,
			started = false,
			ended = false,
			containerId = vb.timeStampId( 'youtubeVideoPlayer' );

		// Track that the player is loaded
		function onPlayerReady() {
			vb.track('player-load');
		}

		// Track when the content first starts playing
		function onPlayerStateChange(e) {
			if ( !started && e.data === 1 ) {
				vb.track('content-begin');
				started = true;
			}
			if ( !ended && e.data === 0 ) {
				vb.track('content-end');
				ended = true;
			}
		}

		params.events = {
			'onReady': onPlayerReady,
			'onStateChange': onPlayerStateChange
		};

		function createPlayer() {
			player = new window.YT.Player(containerId, params);
		}

		// Make sure iframe_api is fully loaded before binding onYouTubeIframeAPIReady event
		if ( window.YT ) {
			createPlayer();
		} else {

			window.onYouTubeIframeAPIReady = function() {
				createPlayer();
			};
			loader({
				type: loader.JS,
				resources: 'https://www.youtube.com/iframe_api'
			});
		}
	};
});
