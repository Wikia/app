/*global WikiaLogger: true, WikiaTracker_ABtests: true, _gaq: true */
var WikiaTracker = {
};

// FIXME refactor inGroup / userGroup / isTracked, it should be much simpler now
WikiaTracker.debug = function (msg, level, obj) {
	return true;
};

WikiaTracker.track = function(page, profile, events) {
	return true;
};

WikiaTracker._track = function(page, profile, sample, events) {
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
