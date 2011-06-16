$.extend({
	/**
	 * JS version of wfMsg()
	 *
	 * Examples:
	 *
	 *  $.msg('foo');
	 *  $.msg('bar', 'test', 'foo');
	 *
	 * @param string key - message name
	 * @param string param - message parameter #1
	 * @param string param - message parameter #2
	 * ...
	 * @return string - localised message
	 */
	msg: function() {
		// get the first function parameter
		var key = Array.prototype.shift.call(arguments),
			// then the rest of parameters as message arguments
			params = arguments;

		// default value to be returned
		var ret = false;

		if (typeof wgMessages != 'undefined') {
			ret = wgMessages[key] || ret;

			// replace $1, $2, $3, ...  with parameters provided
			if (ret !== false && params && params.length) {
				$.each(params, function(i, param) {
					ret = ret.replace(new RegExp('\\$' + parseInt(i+1), 'g'), param);
				});
			}
		}

		return ret !== false ? ret : ('<' + key + '>');
	},

	/**
	 * Load messages from given package(s)
	 *
	 * @param string/array packages - package name or list of packages
	 * @param function callback - function to call when request is completed
	 */
	getMessages: function(packages, callback) {
		// list of packages was given
		if (typeof packages != 'string') {
			packages = Array.prototype.join.call(packages, ',');
		}

		$().log('loading ' + packages + ' package(s)', 'JSMessages');

		$.get(wgScriptPath + '/wikia.php', {
			controller: 'JSMessages',
			method: 'getMessages',
			format: 'html',
			packages: packages,
			uselang: window.wgUserLanguage,
			cb: window.wgJSMessagesCB
		}, function() {
			$().log(packages + ' package(s) loaded', 'JSMessages');

			if (typeof callback == 'function') {
				callback();
			}
		}, 'script');
	}
});