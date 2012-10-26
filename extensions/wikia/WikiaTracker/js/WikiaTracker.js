/*global WikiaTracker_ABtests: true, _gaq: true */
window.WikiaTracker = (function(){
	/** @private **/

	/**
	 * DO NOT ADD TO THIS LIST WITHOUT CONSULTATION FROM JONATHAN
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
	mainEventName = "trackingevent",
	actionsReverse = {};


	for(var key in actions) {
		actionsReverse[actions[key]] = key;
	}

	/**
	 * Unique entry point to track events on both datawarehouse and GA
	 *
	 * @param String eventName (required) The name of the event, either a custom one or "trackingevent"
	 *        (please speak with Tracking leads before introducing a new event name)
	 * @param Object data (required) A key-value hash of parameters to pass to GA and/or the datawarehouse
	 *        keys:
	 *		       ga_category - GA Category (required for GA tracking)
	 *		       ga_action - GA Action (required for GA tracking), use one of the values from WikiaTracker.ACTIONS and ping the Tracking leads *                         before adding a new one
	 *		       ga_label - GA Label (optional)
	 *		       ga_value - GA Value (optional, integer)
	 *		       href - (optional) if present, delay following outbound link of 100ms (to ensure tracking execution)
	 *             [more custom parameters] - please ping the Tracking leads before adding a new ones
	 * @param string trackingMethod Tracking method [both/ga/internal/none] (optional, default:none)
	 *
	 * @author Hyun Lim <hyun(at)wikia-inc.com>
	 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
	 */
	function trackEvent(eventName, data, trackingMethod){
		var logGroup = 'WikiaTracker',
		eventName = eventName || mainEventName,
		data = data || {},
		trackingMethod = trackingMethod || 'none',
		mouseButton = data.button || false,
		gaqArgs = [];

		// If clicking a link that will unload the page before tracking can happen,
		// let's stop the default event and delay 100ms changing location (at the bottom)
		// FIXME: this doesn't work in Firefox (there is no global event object there).
		if (data && data.href && typeof event != 'undefined') {
			event.preventDefault();
		}

		var ga_category = data['ga_category'],
			ga_action = data['ga_action'],
			ga_label = data['ga_label'],
			ga_value = data['ga_value'];

		if(
			trackingMethod == 'none' ||
			//"ga" or "both" are valid only for "trackingevent", this can be enabled by just uncommenting
			//(eventName != mainEventName && trackingMethod != 'internal') ||
			(
				//ga info is compulsoruy for "both" and "ga"
				trackingMethod in {both:'', ga:''} &&
				(!ga_category || !ga_action || !actionsReverse[ga_action])
			)
		){
			Wikia.log('Missing or invalid parameters', 'error', logGroup);
			return;
		}

		//GA parameters need to be enqueued in the correct order
		if(ga_category)
			gaqArgs.push(ga_category);

		if(ga_action)
			gaqArgs.push(ga_action);

		if(ga_label)
			gaqArgs.push(ga_label);

		if(ga_value)
			gaqArgs.push(ga_value);

		if(trackingMethod == 'internal' || trackingMethod == 'both') {
			Wikia.log(eventName + ' ' + gaqArgs.join('/') + ' [internal track]', 'info', logGroup);
			internalTrack(eventName, data);
		}

		if(trackingMethod == 'ga' || trackingMethod == 'both') {
			Wikia.log(eventName + ' ' + gaqArgs.join('/') + ' [GA track]', 'info', logGroup);

			// uncomment the next line later when GA is re-implemented
			//WikiaTracker.track(null, 'main.sampled', gaqArgs);
			if(window.gaTrackEvent) gaTrackEvent(ga_category, ga_action, ga_label, ga_value, true);
		}

		//delay at the end to make sure all of the above was at least invoked
		if (data && data.href ) {
			if( mouseButton === 1 ) {
				invokeDelayedMiddleClickEvent(data.href);
			} else {
				invokeDelayedLeftClickEvent(data.href);
			}
		}
	}

	function invokeDelayedLeftClickEvent(location) {
		setTimeout(function() {
			document.location = location;
		}, 100);
	}

	function invokeDelayedMiddleClickEvent(location) {
		setTimeout(function() {
			window.open(location, '_blank');
		}, 100);
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
	function internalTrack(event, data, successCallback /* unused */, errorCallback /* unused */, timeout){
		var logGroup = 'WikiaTracker';

		// Require an event argument
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

		for(p in params)
			requestParameters.push(encodeURIComponent(p) + '=' + encodeURIComponent(params[p]));

		requestUrl += '?' + requestParameters.join('&');

		if("async" in script)
			script.async = "async";

		script.src = requestUrl;

		script.onload = script.onreadystatechange = function(abort){
			if(abort || !script.readyState || /loaded|complete/.test(script.readyState)){

				//Handle memory leak in IE
				script.onload = script.onreadystatechange = null;

				//Remove the script
				if(head && script.parentNode)
					head.removeChild(script);

				//Dereference the script
				script = undefined;

				var callback;

				if(!abort && typeof successCallback == 'function')
					setTimeout(successCallback, callbackDelay);
				else if(abort && typeof errorCallback == 'function')
					setTimeout(errorCallback, callbackDelay);
			}
		};

		//Use insertBefore instead of appendChild  to circumvent an IE6 bug.
		//This arises when a base node is used (#2709 and #4378).
		head.insertBefore(script, head.firstChild);

		if(timeout > 0){
			setTimeout(function(){
					if(script)
						script.onload(true);
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
	}

	//init
	//if there were any tracking events in the spool from before this file loaded, replay them.
	if (typeof wikiaTrackingSpool !== 'undefined') {
		for(var x = 0, y = wikiaTrackingSpool.length; x < y; x++){
			eventData = wikiaTrackingSpool[x];

			Wikia.log('Sending previously-spooled tracking event', 'trace', 'WikiaTracker');
			Wikia.log(eventData, 'trace', 'WikiaTracker');

			trackEvent.apply(this, eventData);
		}

		wikiaTrackingSpool = null;
	}

	/** @public **/

	return {
		ACTIONS: actions,
		ACTIONS_REVERSE: actionsReverse,
		trackEvent: trackEvent
	};
})();

// TODO remove if really unused
WikiaTracker.track = function(page, profile, events) {
	WikiaTracker.trackAdEvent('liftium.errors', {'ga_category':'errors/wikiatracker', 'ga_action':'track', 'ga_label':page}, 'ga');

	return false;
};

// TODO remove if really unused
WikiaTracker._track = function(page, profile, sample, events) {
	WikiaTracker.trackAdEvent('liftium.errors', {'ga_category':'errors/wikiatracker', 'ga_action':'_track', 'ga_label':page}, 'ga');

	return false;
};

// TODO refactor back into trackEvent
WikiaTracker.trackAdEvent = function(eventName, data, trackingMethod) {
		var logGroup = 'WikiaTracker',
		gaqArgs = [];

		var ga_category = data['ga_category'],
			ga_action = data['ga_action'],
			ga_label = data['ga_label'],
			ga_value = data['ga_value'];

		//GA parameters need to be enqueued in the correct order
		if(ga_category)
			gaqArgs.push(ga_category);

		if(ga_action)
			gaqArgs.push(ga_action);

		if(ga_label)
			gaqArgs.push(ga_label);

		if(ga_value)
			gaqArgs.push(ga_value);

		if(trackingMethod == 'ga' || trackingMethod == 'both') {
			Wikia.log(eventName + ' ' + gaqArgs.join('/') + ' [GA track]', 'info', logGroup);

			window.gaTrackAdEvent(ga_category, ga_action, ga_label, ga_value, true);
		}
};

WikiaTracker.trackClick = function (paramObject) {
	var trackingObj = {
		ga_category: paramObject.category,
		ga_action: paramObject.action,
		ga_label: paramObject.label
	};
	if (paramObject.value) {
		trackingObj['ga_value'] = paramObject.value;
	}
	if (paramObject.params) {
		$.extend(trackingObj, paramObject.params);
	}
	WikiaTracker.trackEvent(
		'trackingevent',
		trackingObj,
		paramObject.trackingMethod
	);
};
