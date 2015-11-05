/*global require*/
(function () {
	'use strict';

	var window = require('wikia.window'),
		tracker = require('wikia.tracker'),
		wikia = window.Wikia = window.Wikia || {};

	/**
	 * Hack to add ability to track video views inside flite.
	 * Used specifically for the 'content-begin' event.
	 * Jira ADEN-295 and VID-517
	 *
	 * Call like this from flite:
	 * window.Wikia.fliteOoyalaTracker( 'video-identifier' );
	 *
	 * @param {String} id Identifier for video, either title or id
	 */

	wikia.fliteOoyalaTracker = function (id) {
		tracker.track({
			action: 'content-begin',
			category: 'video-player-stats',
			label: 'ooyala',
			trackingMethod: 'internal',
			title: id || '',
			clickSource: 'ad'
		});
	};
})();
