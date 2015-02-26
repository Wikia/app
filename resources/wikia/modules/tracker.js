/**
 * Event tracking for GA and our internal datawarehouse.
 * This file depends on "resources/modules/tracker.stub.js" and serves
 * as the actual implementation for the methods and properties defined there.
 *
 * @author Kyle Florence <kflorence@wikia-inc.com>
 * @author Hyun Lim <hyun@wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
(function( window ) {
	'use strict';

	// Depends on tracker.stub.js
	var Wikia = window.Wikia,
			trackerStub = Wikia.Tracker;

	// Adds the info from the second hash into the first.
	// If the same key is in both, the key in the second object overrides what's in the first object.
	function extend( target, obj ) {
		var key;

		for( key in obj ) {
			target[ key ] = obj[ key ];
		}

		return target;
	}

	function tracker( window ) {
		/** @private **/
		var	args,
			// Convenience mappings for keys that can be passed into
			// the Wikia.Tracker.Track method.
			dataKeyMap = {
				action: 'ga_action',
				category: 'ga_category',
				label: 'ga_label',
				value: 'ga_value'
			},
			// The argument order for GA calls
			gaPushOrder = [
				'ga_category',
				'ga_action',
				'ga_label',
				'ga_value'
			],
			// @see /extensions/wikia/AnalyticsEngine/js/analytics.js
			gaTrackAdEvent = window.gaTrackAdEvent,
			gaTrackEvent = window.gaTrackEvent,
			logGroup = 'Wikia.Tracker',
			// These keys will be removed from tracking data before it gets sent to
			// GA or the internal datawarehouse.
			purgeFromData = [
				'browserEvent',
				'eventName',
				'trackingMethod'
			],
			rDoubleSlash = /\/\//g,
			slice = [].slice,
			spool = trackerStub.spool;

		/**
		 * Detects if an action made on event target was left mouse button click with ctrl key pressed (bugId:45483)
		 *
		 * @param browserEvent
		 * @return Boolean
		 */
		function isCtrlLeftClick( browserEvent ) {
			var result = false;

			if ( browserEvent && browserEvent.ctrlKey ) {
				// Microsoft left mouse button === 1
				if ( browserEvent.button === 1 ) {
					result = true;

				} else if ( browserEvent.button === 0 ) {
					result = true;
				}
			}

			return result;
		}

		/**
		 * Detects if an action made on event target was middle mouse button click in a webkit browser (bugId:31900)
		 *
		 * @param browserEvent
		 * @return Boolean
		 */
		function isMiddleClick( browserEvent ) {
			var result = false;

			// Microsoft middle mouse button === 4
			if ( browserEvent && browserEvent.button === 4 ) {
				result = true;

			// just-in-case we check if the ctrlKey button isn't pressed to avoid the function
			// returning true in IE when it's not middle click but ctrl + left mouse button click
			} else if ( browserEvent && browserEvent.button === 1 && !browserEvent.ctrlKey ) {
				result = true;
			}

			return result;
		}

		/**
		 * @brief Internal Wikia tracking set up by Garth Webb
		 *
		 * @param string event Name of event
		 * @param object data Extra parameters to track
		 * @param object successCallback callback function on success (optional)
		 * @param object errorCallback callback function on failure (optional)
		 * @param integer timeout How long to wait before declaring the tracking request as failed (optional)
		 */
		function internalTrack( event, data, successCallback /* unused */, errorCallback /* unused */, timeout ) {
			var head = document.head || document.getElementsByTagName( 'head' )[ 0 ] || document.documentElement,
					script = document.createElement( 'script' ),
					callbackDelay = 200,
					requestUrl = 'http://a.wikia-beacon.com/__track/special/' + encodeURIComponent( event ),
					requestParameters = [],
					p,
					params;

			timeout = timeout || 3000;

			if ( !event ) {
				Wikia.log( 'missing required argument: event', 'error', logGroup );
				return;
			}

			Wikia.log( event + ' [event name]', 'trace', logGroup );

			if ( data ) {
				Wikia.log( data, 'trace', logGroup );
			}

			// Set up params object - this should stay in sync with /extensions/wikia/Track/Track.php
			params = {
				'c': window.wgCityId,
				'x': window.wgDBname,
				'a': window.wgArticleId,
				'lc': window.wgContentLanguage,
				'n': window.wgNamespaceNumber,
				'u': window.trackID || window.wgTrackID || 0,
				's': window.skin,
				'beacon': window.beacon_id || '',
				'cb': Math.floor( Math.random() * 99999 )
			};

			// Add data object to params object
			extend( params, data );

			for( p in params ) {
				requestParameters.push( encodeURIComponent( p ) + '=' + encodeURIComponent( params[ p ] ) );
			}

			requestUrl += '?' + requestParameters.join( '&' );

			if( 'async' in script ) {
				script.async = 'async';
			}

			script.src = requestUrl;

			script.onload = script.onreadystatechange = function( abort ) {
				if ( abort || !script.readyState || /loaded|complete/.test( script.readyState ) ) {

					// Handle memory leak in IE
					script.onload = script.onreadystatechange = null;

					// Remove the script
					if ( head && script.parentNode ) {
						head.removeChild( script );
					}

					// Dereference the script
					script = undefined;

					if ( !abort && typeof successCallback === 'function' ) {
						setTimeout( successCallback, callbackDelay );

					} else if ( abort && typeof errorCallback === 'function' ) {
						setTimeout( errorCallback, callbackDelay );
					}
				}
			};

			// Use insertBefore instead of appendChild  to circumvent an IE6 bug.
			// This arises when a base node is used (#2709 and #4378).
			head.insertBefore( script, head.firstChild );

			if ( timeout > 0 ) {
				setTimeout(function() {
					if ( script ) {
						script.onload( true );
					}
				}, timeout );
			}
		}

		/**
		 * Unique entry point to track events to the internal datawarehouse and GA.
		 * PLEASE DO NOT DUPLICATE THIS LOGIC IN OTHER FUNCTIONS.
		 *
		 * @param {Object} options
		 *        A key-value hash of parameters.
		 *
		 *        keys: (Please ping tracking team leads before adding new ones)
		 *            action (required for GA tracking)
		 *                One of the values in Wikia.Tracker.ACTIONS.
		 *            browserEvent (optional)
		 *                The browser event object that triggered this tracking call.
		 *            category (required for GA tracking)
		 *                The category for the event.
		 *            eventName (optional)
		 *                The name of the event. Defaults to "trackingevent".
		 *                Please speak with a tracking team lead before introducing new event names.
		 *            href (deprecated)
		 *                The href string for a link. This was used by outbound links
		 *                to ensure tracking execution. Where posible, bind to "mousedown" instead of "click"
		 *                to prevent navigation before tracking calls go through.
		 *            label (optional for GA tracking)
		 *                The label for the event.
		 *            trackingMethod (required)
		 *                Where to track the event to ("ad", "both", "ga", "internal").
		 *            value (optional for GA tracking)
		 *                The integer value for the event.
		 *
		 * @param {...Object} [optionsN]
		 *        Any number of additional hashes that will be merged into the first.
		 *
		 * @example
		 *
		 *     var defaults = {
		 *         trackingMethod: 'ga',
		 *         category: 'myCategory'
		 *     };
		 *
		 *     Wikia.Tracker.track( defaults, {
		 *         label: 'myLabel',
		 *     });
		 */
		function track( /* options [ , ..., optionsN ] */ ) {
			var args = slice.call( arguments ),
				browserEvent = window.event,
				data = {},
				eventName = 'trackingevent',
				gaqArgs = [],
				i,
				key,
				l,
				tracking = {},
				trackingMethod = 'none',
				value;

			// Merge options
			for ( i = 0, l = args.length; i < l; i++ ) {
				extend( data, args[ i ] );
			}

			// Remap keys for data consistency
			for ( key in dataKeyMap ) {
				if ( ( value = data[ key ] ) !== undefined ) {
					data[ dataKeyMap[ key ] ] = value;
					delete data[ key ];
				}
			}

			browserEvent = data.browserEvent || browserEvent;
			eventName = data.eventName || eventName;
			trackingMethod = data.trackingMethod || trackingMethod;

			// AN-672: temporarily sending all data to internal warehouse
			if (trackingMethod === 'ga') {
				trackingMethod = 'both';
			}

			tracking[ trackingMethod ] = true;

			if ( tracking.both ) {
				tracking.ga = tracking.internal = true;
			}

			if ( tracking.none || ( tracking.ga &&
				// Category and action are compulsory for GA tracking
				( !data.ga_category || !data.ga_action || !trackerStub.ACTIONS_REVERSE[ data.ga_action ] )
			) ) {
				Wikia.log( 'Missing or invalid parameters', 'error', logGroup );
				Wikia.log( data, 'trace', logGroup );
				return;
			}

			// Get rid of unnecessary data
			for ( i = 0, l = purgeFromData.length; i < l; i++ ) {
				delete data[ purgeFromData[ i ] ];
			}

			// Enqueue GA parameters in the proper order
			for ( i = 0, l = gaPushOrder.length; i < l; i++ ) {
				gaqArgs.push( data[ gaPushOrder[ i ] ] );
			}

			Wikia.log( eventName + ' ' +
				gaqArgs.join( '/' ).replace( rDoubleSlash, '/' ) +
				' [' + trackingMethod + ' track]', 'info', logGroup );

			// No-interactive = true
			// @see /extensions/wikia/AnalyticsEngine/js/analytics.js
			gaqArgs.push( true );

			if ( tracking.ad && gaTrackAdEvent ) {
				gaTrackAdEvent.apply( null, gaqArgs );
			} else {
				if ( tracking.ga && gaTrackEvent ) {
					gaTrackEvent.apply( null, gaqArgs );
				}

				if ( tracking.internal ) {
					internalTrack( eventName, data );
				}
			}

			// Handle links which navigate away from the current page
			// NOTE: This is a hack and it should be avoided whenever possible. For most cases, you can bind to
			// the 'onMouseDown' event instead of 'onClick' to allow the browser time to send these events naturally.
			if ( data.href && ( !browserEvent || !isMiddleClick( browserEvent ) && !isCtrlLeftClick( browserEvent ) ) ) {
				if ( browserEvent && typeof browserEvent.preventDefault === 'function' ) {
					browserEvent.preventDefault();
				}

				// Delay at the end to make sure all of the above was at least invoked
				setTimeout(function() {
					document.location = data.href;
				}, 100 );
			}
		}

		// If there are any tracking events in the spool, replay them.
		while( ( args = spool.shift() ) ) {
			Wikia.log( 'Sending previously-spooled tracking event', 'trace', logGroup );
			Wikia.log( args, 'trace', logGroup );

			track.apply( null, args );
		}

		/** @public **/
		return {
			track: track
		};
	}

	// Extending Wikia.Tracker, which is also exported as the AMD module
	extend( trackerStub, tracker( window ) );

}(window, undefined));
