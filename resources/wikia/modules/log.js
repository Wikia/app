/**
 * Logging utility extracted from Liftium's library and further modified
 *
 * @author Przemek Piotrowski (Nef) <ppiotr(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 *
 * @example
 * //AMD
 * var require('wikia.log'); log(123, log.levels.info, 'MyLogGroup');
 *
 * //JS Namespace
 * Wikia.log(123, Wikia.log.levels.info, 'MyLogGroup');
 *
 * //To allow the messages to be printed to the console add log_level=X to the
 * //URL querystring, where X is one of the values in the levels hash (either the hash key or it's value)
 * //e.g. http://glee.wikia.com/wiki/Rachel_Berry?log_level=info
 * //e.g. http://glee.wikia.com/wiki/Rachel_Berry?log_level=info&log_group=MyLogGroup
 *
 * // The higher the log_level, the more messages will be logged.  If you want all messages,
 * // use ?log_level=13 or ?log_level=trace_l3 (they are the same)
 *
 * @see  printMessage for a list of parameters and their description
 */
(function (context) {
	'use strict';

	var cookie,
		SYSLOG_CUTOFF = 8,
		levels = {
			emergency: 0,
			alert: 1,
			critical: 2,
			error: 3,
			warning: 4,
			notice: 5,
			info: 6,
			debug: 7,
			user: 8,
			feedback: 9,
			system: 10,
			trace: 11,
			trace_l2: 12, // trace level 2
			trace_l3: 13 // trace level 3
		};

	function syslog(priority, message, context) {
		// syslogReport defined in Oasis_Index
		if (typeof syslogReport == 'function' && priority < SYSLOG_CUTOFF) {
			syslogReport(priority, message, context);
		}
	}

	function logger() {
		var console = context.console,
			//used for undefined checks
			undef,
			outputLevel = 0,
			groups = {},
			groupsString = '',
			groupsCount = 0,
			enabled = false,
			//used to check for iOS devices
			isIdevice,
			levelsMap = [],
			levelID,
			p;

		for (p in levels) {
			if (levels.hasOwnProperty(p)) {
				levelsMap[levels[p]] = p;
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
		function printMessage(msg, group) {
			if (console !== undef) {
				if (group) {
					//forcing space as IE doesn't
					//add one between parameters
					group += ': ';

					if (isIdevice === undef) {
						isIdevice = /i(pod|pad|phone)/i.test(context.navigator.userAgent);
					}

					if (isIdevice) {
						//iOS doesn't print out more than one parameter
						//and has no tree view for objects
						console.log(group + msg.toString());
					} else {
						console.log(group, msg);
					}
				} else {
					console.log(msg);
				}
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
		 * @param {bool} report whether or not to log the message (to syslog)
		 */
		function logMessage(msg, level, group, report) {
			if (level !== levels.emergency) {
				level = level || 'trace';
			}

			report = report || false;

			if (typeof level === 'number') {
				if (level < 0) {
					level = 0;
				} else if (level > levelsMap.length - 1) {
					level = levelsMap.length - 1;
				}

				level = levelsMap[level];
			}

			level = level.toLowerCase();
			levelID = levels[level];
			group = group || 'Unknown source';

			if (report && levelID < SYSLOG_CUTOFF) {
				printMessage(msg, 'syslog');
				syslog(levelID, msg);
			}

			if (!enabled ||
				(msg === undef) ||
				(levelID > outputLevel) ||
				(groupsCount > 0 && !(groups.hasOwnProperty(group)))) {
				return false;
			}

			printMessage(msg, group);
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

			outputLevel = qs.getVal('log_level') || (cookies && cookies.get('log_level')) || outputLevel;

			if (levels.hasOwnProperty(outputLevel)) {
				outputLevel = levels[outputLevel];
			} else {
				outputLevel = parseInt(outputLevel, 10);
			}

			selectedGroups = (qs.getVal('log_group') || (cookies && cookies.get('log_group')) || '').replace(' ', '').replace('|', ',').split(',');
			groupsString = selectedGroups.join(', ');

			for (x = 0, y = selectedGroups.length; x < y; x++) {
				g = selectedGroups[x];

				if (g !== '') {
					groups[g] = '';
					groupsCount++;
				}
			}

			if (outputLevel > 0) {
				printMessage('initialized at level ' + outputLevel + ((groupsCount > 0) ? ' for ' + groupsString : ''), 'Wikia.log');
				enabled = true;
			}
		}

		//init
		if (context.define) {
			try {
				cookie = require('wikia.cookies');
			} catch (exception) {
				cookie = null;
			}

			init(require('wikia.querystring'), cookie);
		} else {
			init(context.Wikia.Querystring, context.Wikia.Cookies);
		}

		return logMessage;
	}

	//UMD inclusive
	if (!context.Wikia) {
		context.Wikia = {};
	}

	context.Wikia.log = logger();
	//exposing levels to the outside world
	context.Wikia.log.levels = levels;
	context.Wikia.syslog = syslog;

	if (context.define) {
		//AMD
		context.define('wikia.log', function () {
			return context.Wikia.log;
		});
	}
}(this));
