/**
 * Helper module for making AJAX requests to Nirvana controllers
 */
/*global define*/

(function (context) {
	'use strict';

	function nirvana(ajax) {
		function sendRequest(attr) {
			var type = (attr.type || 'POST').toUpperCase(),
				format = (attr.format || 'json').toLowerCase(),
				data = attr.data || {},
				callback = attr.callback || function() {},
				onErrorCallback = attr.onErrorCallback || function() {},
				url,
				getUrl;

			if((typeof attr.controller === 'undefined') || (typeof attr.method === 'undefined')) {
				throw "controller and method are required";
			}

			if( !(format === 'json' || format === 'html' || format === 'jsonp' ) ) {
				throw "Only Json,Jsonp and Html format are allowed";
			}

			url = attr.scriptPath || context.wgScriptPath;

			getUrl = {
				//Iowa strips out POST parameters, Nirvana requires these to be set
				//so we're passing them in the GET part of the request
				controller: attr.controller.replace(/Controller$/, ''),
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

			return ajax({
				url: url + '/wikia.php?' + $.param(getUrl), /* JSlint ignore */
				dataType: format,
				type: type,
				data: sortedDict,
				success: callback,
				error: onErrorCallback
			});
		}

		return {
			sendRequest: sendRequest,
			getJson: function(controller, method, data, callback, onErrorCallback) {
				if(typeof data == 'function') {
					data = {};
					callback = data;
					onErrorCallback = callback;
				}
				return sendRequest({
					controller: controller,
					method: method,
					data: data,
					type: 'GET',
					callback: callback,
					onErrorCallback: onErrorCallback
				});
			},
			postJson: function (controller, method, data, callback, onErrorCallback) {
				if(typeof data == 'function') {
					data = {};
					callback = data;
					onErrorCallback = callback;
				}
				return sendRequest({
					controller: controller,
					method: method,
					data: data,
					callback: callback,
					onErrorCallback: onErrorCallback
				});
			}
		};
	}

	if (context.define && context.define.amd) {
		context.define('wikia.nirvana', ['wikia.ajax'], nirvana);
	}

	if(context.jQuery) {
		context.jQuery.nirvana = nirvana(context.jQuery.ajax);
	}
}(this));
