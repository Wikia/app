/*global console: true, opera: true */
/**
 * Logging utility extracted from Liftium's library and further modified
 *
 * @author Przemek Piotrowski (Nef) <ppiotr(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
(function (context) {
	'use strict';

	function logger() {
		var levels = {
				user: 1,
				feedback: 2,
				info: 3,
				system: 4,
				warning: 5,
				error: 6,
				debug: 7,
				trace: 8,
				trace_l2: 9,
				trace_l3: 10
			},
			outputLevel = 0,
			groups = {},
			groupsString = '',
			groupsCount = 0,
			enabled = false,
			levelsMap = [],
			levelID,
			p,
			v;

		for (p in levels) {
			if (levels.hasOwnProperty(p)) {
				v = levels[p];

				if (v) {
					levelsMap[v] = p;
				}
			}
		}

		/**
		 * Selects a viable output (if any) and prints a message/value
		 *
		 * @private
		 *
		 * @param {Mixed} msg The value to print
		 * @param {Integer} level The log level
		 * @param {String} group The log group
		 */
		function printMessage(msg, level, group) {
			if (typeof console !== 'undefined') {
				console.log((typeof msg !== 'object' ? '%s: %s' : '%s: %o'), group, msg);
			} else if (typeof opera !== 'undefined') {
				opera.postError(group + ': ' + msg);
			}
		}

		/**
		 * Logs a message/value to the console
		 *
		 * @public
		 *
		 * @param {Mixed} msg The value to print
		 * @param {Integer} level The log level
		 * @param {String} group The log group
		 */
		function logMessage(msg, level, group) {
			level = level || 'trace';

			if (typeof level === 'number') {
				if (level < 1) {
					level = 1;
				} else if (level > levelsMap.length - 1) {
					level = levelsMap.length - 1;
				}

				level = levelsMap[level];
			}

			level = level.toLowerCase();
			levelID = levels[level];
			group = group || 'Unknown source';

			if (!enabled ||
					(typeof msg === "undefined") ||
					(levelID > outputLevel) ||
					(groupsCount > 0 && !(groups.hasOwnProperty(group)))) {
				return false;
			}

			printMessage(msg, level, group);
			return true;
		}

		/**
		 * Initializes the module
		 *
		 * @private
		 *
		 * @param {Object} querystring The QueryString module
		 * @param {Object} cookies The Cookies module
		 */
		function init(querystring, cookies) {
			var qs = new querystring(),
				selectedGroups,
				x,
				y,
				g;

			outputLevel = qs.getVal('log_level') || cookies.get('log_level') || outputLevel;

			if (levels.hasOwnProperty(outputLevel)) {
				outputLevel = levels[outputLevel];
			} else {
				outputLevel = parseInt( outputLevel, 10);
			}

			selectedGroups = (qs.getVal('log_group') || cookies.get('log_group') || '').replace(' ', '').replace('|', ',').split(',');
			groupsString = selectedGroups.join(', ');

			for (x = 0, y = selectedGroups.length; x < y; x++) {
				g = selectedGroups[x];

				if (g !== '') {
					groups[g] = '';
					groupsCount++;
				}
			}

			if (outputLevel > 0) {
				printMessage('initialized at level ' + outputLevel + ((groupsCount > 0) ? ' for ' + groupsString : ''), 'info', 'Wikia.log');
				enabled = true;
			}
		}

		//init
		if (context.require && context.define && context.define.amd) {
			context.require(['querystring', 'cookies'], init);
		} else {
			init(context.Wikia.Querystring, context.Wikia.Cookies);
		}

		return logMessage;
	}

	//UMD inclusive
	if (!context.Wikia) {
		context.Wikia = {};
	}

	context.Wikia.log = logger();//late binding

	if (context.define && context.define.amd) {
		//AMD
		context.define('log', function () {
			return context.Wikia.log;
		});
	}
}(this));