$.extend({
	/*
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
	}
});