(function (context) {

	function tracker(window) {
		/** @private **/

		/**
		 * DO NOT ADD TO THIS LIST WITHOUT CONSULTATION FROM TRACKING TEAM LEADS
		 * Keep it in alphabetical order
		 */
		var actions = {
				// Generic add
				ADD: 'add',

				// Generic click, mostly javascript clicks
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
			dataKeyMap = {
				action: 'ga_action',
				category: 'ga_category',
				label: 'ga_label',
				value: 'ga_value'
			},
			gaPushOrder = [
				'ga_category',
				'ga_action',
				'ga_label',
				'ga_value'
			],
			// @see /extensions/wikia/AnalyticsEngine/js/analytics_prod.js
			gaTrackAdEvent = window.gaTrackAdEvent,
			gaTrackEvent = window.gaTrackEvent,
			logGroup = 'WikiaTracker',
			purgeFromData = [
				'browserEvent',
				'eventName',
				'trackingMethod'
			],
			rDoubleSlash = /\/\//g,
			slice = [].slice;

		/**
		 * Unique entry point to track events to the internal datawarehouse and GA.
		 * PLEASE DO NOT DUPLICATE THIS LOGIC IN OTHER FUNCTIONS.
		 *
		 * @param {Object} options
		 *        A key-value hash of parameters.
		 *
		 *        keys: (Please ping tracking team leads before adding new ones)
		 *            action (required for GA tracking)
		 *                One of the values in WikiaTracker.ACTIONS.
		 *            browserEvent (optional)
		 *                The browser event object that triggered this tracking call.
		 *            category (required for GA tracking)
		 *                The category for the event.
		 *            eventName (optional)
		 *                The name of the event. Defaults to "trackingevent".
		 *                Please speak with a tracking team lead before introducing new event names.
		 *            href (optional)
		 *                The href string for a link. This should be used by outbound links
		 *                to ensure tracking execution.
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
		 *     WikiaTracker.track( defaults, {
		 *         label: 'myLabel',
		 *     });
		 *
		 * @author Kyle Florence <kflorence@wikia-inc.com>
		 * @author Hyun Lim <hyun(at)wikia-inc.com>
		 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
		 */
		function track( /* options [ , ..., optionsN ] */ ) {
			var args = slice.call( arguments ),
				browserEvent = window.event,
				data = {},
				eventName = 'trackingevent',
				gaqArgs = [],
				i = 0,
				key,
				l = args.length,
				tracking = {},
				trackingMethod = 'none',
				value;

			// Merge options
			for ( ; i < l; i++ ) {
				extendObject( data, args[ i ] );
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
			tracking[ trackingMethod ] = true;

			if ( tracking.both ) {
				tracking.ga = tracking.internal = true;
			}

			if ( tracking.none || ( tracking.ga &&
				// Category and action are compulsory for GA tracking
				( !data.ga_category || !data.ga_action || !actionsReverse[ data.ga_action ] )
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
			// @see /extensions/wikia/AnalyticsEngine/js/analytics_prod.js
			gaqArgs.push( true );

			if ( tracking.ad && gaTrackAdEvent ) {
				gaTrackAdEvent.apply( null, gaqArgs );

			} else if ( tracking.ga && gaTrackEvent ) {
				gaTrackEvent.apply( null, gaqArgs );

			} else if ( tracking.internal ) {
				internalTrack( eventName, data );
			}

			// Handle links which navigate away from the current page
			if ( data.href && ( !browserEvent || !isMiddleClick( browserEvent ) && !isCtrlLeftClick( browserEvent ) ) ) {
				if ( browserEvent && typeof browserEvent.preventDefault === 'function' ) {
					browserEvent.preventDefault();
				}

				// Delay at the end to make sure all of the above was at least invoked
				// FIXME: there must be a better way to do this that avoids using setTimeout.
				setTimeout(function() {
					document.location = data.href;
				}, 100 );
			}
		}

		/**
		 * Function factory for building custom tracking methods with default parameters.
		 *
		 *     var track = WikiaTracker.buildTrackingFunction({
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
		 *
		 * @author Kyle Florence <kflorence@wikia-inc.com>
		 */
		function buildTrackingFunction() {
			var args = slice.call( arguments );

			return function() {
				return track.apply( null, args.concat( slice.call( arguments ) ) );
			};
		}

		/**
		 * Detects if an action made on event target was left mouse button click with ctrl key pressed
		 *
		 * @param browserEvent
		 * @return Boolean
		 */
		function isCtrlLeftClick(browserEvent) {
			//bugId:45483
			var result = false;

			if( browserEvent && browserEvent.ctrlKey ) {
				if( browserEvent.button === 1 ) {
				//Microsoft left mouse button === 1
					result = true;
				} else if( browserEvent.button == 0 ) {
					result = true;
				}
			}

			return result;
		}

		/**
		 * Detects if an action made on event target was middle mouse button click in a webkit browser
		 *
		 * @param browserEvent
		 * @return Boolean
		 */
		function isMiddleClick(browserEvent) {
			//bugId:31900
			var result = false;

			if( browserEvent && browserEvent.button === 4 ) {
			//Microsoft middle mouse button === 4
				result = true;
			} else if( browserEvent && browserEvent.button == 1 && !browserEvent.ctrlKey ) {
			//just-in-case we check if the ctrlKey button isn't pressed to avoid the function
			//returning true in IE when it's not middle click but ctrl + left mouse button click
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
		 *
		 * @author Christian
		 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
		 */
		function internalTrack(event, data, successCallback /* unused */, errorCallback /* unused */, timeout) {
			if (!event) {
				Wikia.log('missing required argument: event', 'error', logGroup);
				return;
			}

			Wikia.log(event + ' [event name]', 'trace', logGroup);

			if(data) {
				Wikia.log(data, 'trace', logGroup);
			}

			// Set up params object - this should stay in sync with /extensions/wikia/Track/Track.php
			var params = {
				'c': wgCityId,
				'x': wgDBname,
				'a': wgArticleId,
				'lc': wgContentLanguage,
				'n': wgNamespaceNumber,
				'u': window.trackID || window.wgTrackID || 0,
				's': skin,
				'beacon': window.beacon_id || '',
				'cb': Math.floor(Math.random()*99999)
			};

			// Add data object to params object
			extendObject(params, data);
			var head = document.head || document.getElementsByTagName('head')[0] || document.documentElement,
				script = document.createElement( "script" ),
				callbackDelay = 200,
				timeout = timeout || 3000,
				requestUrl = 'http://a.wikia-beacon.com/__track/special/' + encodeURIComponent(event),
				requestParameters = [],
				p;

			for(p in params) {
				requestParameters.push(encodeURIComponent(p) + '=' + encodeURIComponent(params[p]));
			}

			requestUrl += '?' + requestParameters.join('&');

			if("async" in script) {
				script.async = "async";
			}

			script.src = requestUrl;

			script.onload = script.onreadystatechange = function(abort){
				if(abort || !script.readyState || /loaded|complete/.test(script.readyState)){

					//Handle memory leak in IE
					script.onload = script.onreadystatechange = null;

					//Remove the script
					if(head && script.parentNode) {
						head.removeChild(script);
					}

					//Dereference the script
					script = undefined;

					var callback;

					if(!abort && typeof successCallback == 'function') {
						setTimeout(successCallback, callbackDelay);
					} else if(abort && typeof errorCallback == 'function') {
						setTimeout(errorCallback, callbackDelay);
					}
				}
			};

			//Use insertBefore instead of appendChild  to circumvent an IE6 bug.
			//This arises when a base node is used (#2709 and #4378).
			head.insertBefore(script, head.firstChild);

			if(timeout > 0){
				setTimeout(function(){
						if(script) {
							script.onload(true);
						}
					},
					timeout
				);
			}
		};

		// Adds the info from the second hash into the first.
		// If the same key is in both, the key in the second object overrides what's in the first object.
		function extendObject(obj, ext){
			for(var p in ext){
				obj[p] = ext[p];
			}

			return obj;
		}

		/** @public **/

		return {
			ACTIONS: actions,
			ACTIONS_REVERSE: actionsReverse,
			buildTrackingFunction: buildTrackingFunction,
			track: track
		};
	}

	if (context.define && context.define.amd) {
		context.define('wikia.tracker', ['wikia.window'], tracker);
	}

	WikiaTracker = tracker(context);

}(this));
