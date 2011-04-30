$.extend({
	msg: function(key, params) {
		// default value to be returned
		var ret = false;

		if (typeof wgMessages != 'undefined') {
			ret = wgMessages[key] || ret;

			// replace $1, $2, $3, ...  with parameters provided
			if (ret !== false && params) {
				$.each(params, function(i, param) {
					ret = ret.replace(new RegExp('\\$' + parseInt(i+1), 'g'), param);
				});
			}
		}

		return ret !== false ? ret : ('<' + key + '>');
	}
});