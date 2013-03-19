/**
 * This is a stub for the tracker implementation, it contains all public
 * methods and properties that will exist for the tracker API but acts only
 * as a proxy for early tracking method calls. For the full implementation,
 * see "resources/modules/tracker.js"
 *
 * @author Kyle Florence <kflorence@wikia-inc.com>
 */
(function( context ) {
	'use strict';

	// quick fix for fb#98739
	if ( context.Wikia && context.Wikia.Tracker ) {
		return;
	}

	function tracker( window ) {
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

				// impression of item on page/module
				IMPRESSION: 'impression',

				// Video play
				PLAY_VIDEO: 'play-video',

				// Removal
				REMOVE: 'remove',

				// Generic paginate
				PAGINATE: 'paginate',

				// Sharing view email, social network, etc
				SHARE: 'share',

				// Form submit, usually a post method
				SUBMIT: 'submit',

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
			slice = [].slice,
			spool = [];

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
		 * @params {Object} defaults
		 *         A key-value hash of parameters.
		 *
		 * @see The track method above for hash key information.
		 */
		function buildTrackingFunction() {
			var args = slice.call( arguments );

			return function() {
				return Wikia.Tracker.track.apply( null, args.concat( slice.call( arguments ) ) );
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
	context.Wikia = context.Wikia || {};
	context.Wikia.Tracker = tracker( context );

	// quick fix for fb#98739
	context.WikiaTracker = context.Wikia.Tracker;

	if (context.define && context.define.amd) {
		context.define('wikia.tracker', ['wikia.window'], tracker);
	}

})(this);