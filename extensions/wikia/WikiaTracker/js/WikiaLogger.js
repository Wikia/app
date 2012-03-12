/*global console: true, opera: true */
var WikiaLogger = {
	level:0,
	groups:[],
	_enabled_cache:false
};

WikiaLogger.log = function(msg, level, group) {
	if (!this._enabled_cache) {
		return false;
	}

	if (typeof msg == 'undefined' || typeof level == 'undefined' || typeof group == 'undefined') {
		return false;
	}

	if (level > this.level) {
		return false;
	}

	if (this.groups.indexOf(group) == -1) {
		return false;
	}

	this._log(msg, group);
	return true;
};

WikiaLogger._log = function(msg, group) {
	if (typeof console != 'undefined') {
		console.log((typeof msg != 'object' ? '%s: %s' : '%s: %o'), group, msg);
	}
	else if (typeof opera != 'undefined') {
		opera.postError(group + ': ' + msg);
	}
};

WikiaLogger.init = function() {
	if (typeof jQuery == 'function') {
		this.level = parseInt($.getUrlVar('log_level') || $.cookies.get('log_level')) || this.level;
		this.groups = ($.getUrlVar('log_group') || $.cookies.get('log_group') || '').replace(' ', '').replace('|', ',').split(',');
	}

	if (this.level > 0 && this.groups.length > 0) {
		this._log('initialized at level ' + this.level + ' for ' + this.groups.join(', '), 'WikiaLogger.g');
		this._enabled_cache = true;
	}
};

WikiaLogger.init();