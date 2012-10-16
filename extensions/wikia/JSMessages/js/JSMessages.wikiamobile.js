/* globals Zepto */
define('JSMessages', function(){
	'use strict';

	/**
	 * JS version of wfMsg()
	 *
	 * Examples:
	 *
	 *  require('JSMessages', function(msg){
	 *
	 *  	msg('foo');
	 *  	msg('bar', 'test', 'foo');
	 *
	 *		msg.get();
	 *
	 *		msg.getForContent();
	 *  })
	 *
	 *
	 * @param key string - message name
	 * @param param string - message parameter #1
	 * @param param string - message parameter #2
	 * ...
	 * @return string - localised message
	 */
	function msg() {
		// get the first function parameter
		// then the rest are parameters to a message
		var key = Array.prototype.shift.call(arguments),
			// default value to be returned
			ret = key;

		if (window.wgMessages) {
			ret = wgMessages[key] || ret;

			// replace $1, $2, $3, ...  with parameters provided
			if (arguments && ret !== key && arguments.length) {
				for(var i = 0, l = arguments.length; i < l; i++){
					ret = ret.replace(new RegExp('\\$' + (i+1), 'g'), arguments[i]);
				}
			}
		}

		return ret;
	}

	/**
	 * Load messages from given package(s)
	 *
	 * @param packages string/array - package name or list of packages
	 * @param callback function - function to call when request is completed
	 * @param language string - optionally language code (fallbacks to user language)
	 */
	 msg.get = function(packages, callback, language) {
		// list of packages was given
		if (typeof packages !== 'string') {
			packages = Array.prototype.join.call(packages, ',');
		}

		// by default use user language
		language = language || window.wgUserLanguage;

		$.post(wgScriptPath + '/wikia.php', {
			controller: 'JSMessages',
			method: 'getMessages',
			format: 'html',
			packages: packages,
			uselang: language,
			cb: window.wgJSMessagesCB
		}, function(result) {

			Wikia.processScript(result);

			if (typeof callback === 'function') {
				callback();
			}
		}, 'script');
	};

	/**
	 * Load messages from given package(s) using content language
	 */
	msg.getForContent = function(packages, callback) {
		this.get(packages, callback, window.wgContentLanguage);
	};

	return msg;
});