/**
 * Helper "class" to send ajax request to nirvana controller
 *
 * @author TomekO
 */
(function($) {

$.nirvana = {
	sendRequest: function(attr) {
		var type = (typeof attr.type == 'undefined') ? 'POST' : attr.type.toUpperCase();
		var format = (typeof attr.format == 'undefined') ?  'json' : attr.format.toLowerCase();
		var data = (typeof attr.data == 'undefined') ? {} : attr.data;
		var callback = (typeof attr.callback == 'undefined') ? function(){} : attr.callback;
		var onErrorCallback = (typeof attr.onErrorCallback == 'undefined') ? function(){} : attr.onErrorCallback;

		if((typeof attr.controller == 'undefined') || (typeof attr.method == 'undefined')) {
			throw "controller and method are required";
		}

		if( !(format === 'json' || format === 'html'  || format === 'jsonp' ) ) {
			throw "Only Json,Jsonp and Html format are allowed";
		}

		var url = (typeof attr.scriptPath == 'undefined') ? wgScriptPath : attr.scriptPath;

		var getUrl = { /* JSlint ignore */
			//Iowa strips out POST parameters, Nirvana requires these to be set
			//so we're passing them in the GET part of the request
			controller: attr.controller,
			method: attr.method
		};

		(type == 'POST' ? getUrl : data).format = format;

		var sortedKeys = [];
		for(var key in data) {
			sortedKeys[sortedKeys.length] = key;
		}
		sortedKeys.sort();
		var sortedDict = {};
		for(var i = 0; i < sortedKeys.length; i++) {
			sortedDict[sortedKeys[i]] = data[sortedKeys[i]];
		}

		return $.ajax({
			url: url + '/wikia.php?' + $.param(getUrl),
			dataType: format,
			type: type,
			data: sortedDict,
			success: callback,
			error: onErrorCallback
		});
	},

	getJson: function(controller, method, data, callback, onErrorCallback) {
		return $.nirvana.ajaxJson(
			controller,
			method,
			data,
			callback,
			onErrorCallback,
			'GET'
		);
	},

	postJson: function(controller, method, data, callback, onErrorCallback) {
		return $.nirvana.ajaxJson(
			controller,
			method,
			data,
			callback,
			onErrorCallback,
			'POST'
		);
	},

	ajaxJson: function(controller, method, data, callback, onErrorCallback, requestType) {
		// data parameter can be omitted
		if ( typeof data == 'function' ) {
			callback = data;
			data = {};
		}

		return $.nirvana.sendRequest({
			controller: controller,
			method: method,
			data: data,
			type: requestType,
			format: 'json',
			callback: callback,
			onErrorCallback: onErrorCallback
		});
	}
};

})(jQuery);
