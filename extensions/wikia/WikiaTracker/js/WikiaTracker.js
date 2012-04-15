/*global WikiaLogger: true, WikiaTracker_ABtests: true, _gaq: true */
var WikiaTracker = {

	/**
	 * DO NOT ADD TO THIS LIST WITHOUT CONSULTATION FROM JONATHAN
	 * Keep it in alphabetical order
	 */
	ACTIONS: {
		// Generic add
		ADD: 'add',

		// Generic click, mostly javascript clicks
		CLICK: 'click',

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

		// Form submit, usually a post method
		SUBMIT: 'submit',

		// Action to take a survey
		TAKE_SURVEY: 'take-survey',

		// View
		VIEW: 'view'
	},

	/**
	 *	params - json of key value pairs
	 *  keys:
	 *		tracking_method - tracking method [both/ga/internal/none] (optional, default:internal)
	 *		ga_category - GA Category (required)
	 *		ga_action - GA Action (required), use one of the values from WikiaTracker.ACTIONS
	 *		ga_label - GA Label (optional)
	 *		ga_value = GA Value (optional)
	 *		internal_params - JSON (optional)
	 *		internal_params.href - (optional) if present, delay following outbound link 100ms
	 */
	trackEvent: function(params) {

		// If clicking a link that will unload the page before tracking can happen… delay 100ms.
		if (typeof params.internal_params === 'object' && typeof params.internal_params.href !== 'undefined') {
			event.preventDefault();
			setTimeout(function() {
				document.location = params.internal_params.href;
			}, 100);
		}

		var trackingMethod = params['tracking_method'] || 'none',
			ga_category = params['ga_category'],
			ga_action = params['ga_action'],
			ga_label = params['ga_label'],
			ga_value = params['ga_value'];

		if(!ga_category || !ga_action || trackingMethod === 'none' || !WikiaTracker.ACTIONS_REVERSE[ga_action]) {
			$().log('Required parameters are missing or invalid');
			return;
		}

		var gaqArgs = [
			ga_category,
			ga_action
		], internalParamsObj = {
			ga_category: ga_category,
			ga_action: ga_action
		};

		if(ga_label) {
			internalParamsObj['ga_label'] = ga_label;
			gaqArgs.push(ga_label);
		}
		if(ga_value) {
			internalParamsObj['ga_value'] = ga_value;
			gaqArgs.push(ga_value);
		}

		if(trackingMethod == 'internal' || trackingMethod == 'both') {
			$.extend(internalParamsObj, params['internal_params'] || {});
			$().log('internal tracked');
			$.internalTrack('trackingevent', internalParamsObj);
		}

		if(trackingMethod == 'ga' || trackingMethod == 'both') {
			$().log('ga tracked');
			// uncomment the next line later when GA is re-implemented
			// WikiaTracker.track(null, 'main.sampled', gaqArgs);
		}

		$().log(Array.prototype.join.call(gaqArgs, '/'), 'tracker [event]');
	}
};

WikiaTracker.ACTIONS_REVERSE = (function() {
	var actions_reverse = {},
		actions = WikiaTracker.ACTIONS,
		key;
	for(key in actions) {
		actions_reverse[actions[key]] = key;
	}
	return actions_reverse;
})();

// FIXME refactor inGroup / userGroup / isTracked, it should be much simpler now
WikiaTracker.debug = function (msg, level, obj) {
	return true;
};

WikiaTracker.track = function(page, profile, events) {
	return true;

	if (typeof page != 'undefined' && page instanceof Array) {
		page = page.join('/');
	}

	this.debug(page + ' in ' + profile, 3, events);

	return this._track(page, profile, 100, events);
};

WikiaTracker._track = function(page, profile, sample, events) {
	this.debug(page + ' in ' + profile + ' at ' + sample + '%', 7);

	if (typeof events != 'undefined' && events instanceof Array) {
		this.debug('...with events: ' + events.join('/'), 7);

		events.unshift('_trackEvent');
		_gaq.push(events);
	}

	if (page != null) {
		if (page.indexOf('/') != 0) {
			page = '/' + page;
		}

		_gaq.push(['_trackEvent', 'fakeurl', page]);
	}

	return true;
};

WikiaTracker._simpleHash = function(s, tableSize) {
		var i, hash = 0;
		for (i = 0; i < s.length; i++) {
			hash += (s.charCodeAt(i) * (i+1));
		}
		return Math.abs(hash) % tableSize;
 };

WikiaTracker._inGroup = function(hash_id, group_id) {
	return false;
};

WikiaTracker._userGroup = function() {
	return null;
};

WikiaTracker.inGroup = function(group) {
	return false;
};

WikiaTracker.isTracked = function() {
	return this.inGroup('N');
};

WikiaTracker._abData = function() {
	var in_ab = [];

	return in_ab;
};

WikiaTracker.AB = function(page) {
	return true;
};



/*
if (typeof jQuery == 'function') {
	if ($.getUrlVar('wikiatracker_is_tracked') || $.cookies.get('wikiatracker_is_tracked')) {
		WikiaTracker._in_group_cache['N'] = true;
	}
	var _temp_ab_group = $.getUrlVar('wikiatracker_ab_group') || $.cookies.get('wikiatracker_ab_group');
	if (_temp_ab_group) {
		WikiaTracker._in_group_cache[_temp_ab_group] = true;
		WikiaTracker._in_group_cache['N'] = true;
	}
}
*/
