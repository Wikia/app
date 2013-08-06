/**
 * This is a stub for the tracker implementation, it contains all public
 * methods and properties that will exist for the tracker API but acts only
 * as a proxy for early tracking method calls. For the full implementation,
 * see "resources/modules/tracker.js"
 *
 * @author Kyle Florence <kflorence@wikia-inc.com>
 */
(function( window ) {
	'use strict';
	var Wikia = window.Wikia || {};

	function tracker() {
		/** @private **/

		/**
		 * DO NOT ADD TO THIS LIST WITHOUT CONSULTATION FROM TRACKING TEAM LEADS
		 * Keep it in alphabetical order
		 */
		var actions = {
				// Generic add
				ADD: 'add',

				// Generic click, mostly javascript clicks
				// NOTE: When tracking clicks, consider binding to 'onMouseDown' instead of 'onClick'
				// to allow the browser time to send these events naturally. For more information on
				// this issue, see the `track()` method in "resources/modules/tracker.js"
				CLICK: 'click',

				// Click on navigational button
				CLICK_LINK_BUTTON: 'click-link-button',

				// Click on image link
				CLICK_LINK_IMAGE: 'click-link-image',

				// Click on text link
				CLICK_LINK_TEXT: 'click-link-text',

				// Generic close
				CLOSE: 'close',

				// Clicking okay in a confirmation modal
				CONFIRM: 'confirm',

				// Generic hover
				HOVER: 'hover',

				// impression of item on page/module
				IMPRESSION: 'impression',

				// Generic keypress
				KEYPRESS: 'keypress',

				// Video play
				PLAY_VIDEO: 'play-video',

				// Removal
				REMOVE: 'remove',

				// Generic open
				OPEN: 'open',

				// Generic paginate
				PAGINATE: 'paginate',

				// Sharing view email, social network, etc
				SHARE: 'share',

				// Form submit, usually a post method
				SUBMIT: 'submit',

				// Successful ajax response
				SUCCESS: 'success',

				// General swipe event
				SWIPE: 'swipe',

				// Action to take a survey
				TAKE_SURVEY: 'take-survey',

				// View
				VIEW: 'view'
			},
			actionsReverse = (function() {
				var obj = {},
					key;

				for ( key in actions ) {
					obj[ actions[ key ] ] = key;
				}

				return obj;
			})(),
			spool = [],
			slice = spool.slice;

		/**
		 * Stub method for queueing early tracking calls.
		 *
		 * @see the track method in "resources/modules/tracker.js" for more information.
		 */
		function track() {
			spool.push( slice.call( arguments ) );
		}

		/**
		 * Function factory for building custom tracking methods with default parameters.
		 *
		 *     var track = Wikia.Tracker.buildTrackingFunction({
		 *         category: 'myCategory',
		 *         trackingMethod: 'ga'
		 *     });
		 *
		 *     track({
		 *         label: 'myLabel'
		 *     });
		 *
		 * @param {Function} [trackingMethod]
		 *        An optional tracking method to use instead of Wikia.Tracker.track.
		 *
		 * @param {Object} options
		 *        A key-value hash of parameters.
		 *
		 * @param {...Object} [optionsN]
		 *        Any number of additional hashes that will be merged into the first.
		 *
		 * @see The track method above for hash key information.
		 */
		function buildTrackingFunction( /* [ trackingMethod, ] options [ , ... optionsN ] */ ) {
			var args = slice.call( arguments ),
				trackingFunction = typeof args[ 0 ] === 'function' && args.shift();

			return function() {
				var track = trackingFunction || Wikia.Tracker.track;
				return track.apply( track, args.concat( slice.call( arguments ) ) );
			};
		}

		/** @public **/
		return {
			ACTIONS: actions,
			ACTIONS_REVERSE: actionsReverse,
			buildTrackingFunction: buildTrackingFunction,
			spool: spool,
			track: track
		};
	}

	// Exports
	window.Wikia = Wikia || {};
	window.Wikia.Tracker = tracker( window );

	if ( window.define && window.define.amd ) {
		window.define( 'wikia.tracker', [ 'wikia.window' ], tracker );
	}

})( window, undefined );
