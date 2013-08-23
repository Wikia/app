/**
 * Helper module for making AJAX requests to Nirvana controllers
 */
/*global define*/

(function (context) {
	'use strict';

	function nirvana($) {

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

			url = attr.scriptPath || context.wgServer + context.wgScriptPath;

			getUrl = {
				//Iowa strips out POST parameters, Nirvana requires these to be set
				//so we're passing them in the GET part of the request
				controller: attr.controller.replace(/Controller$/, ''),
				method: attr.method
			};

			if(type === 'POST') {
				getUrl.format = format;
			} else {
				if(typeof data == 'string') {
					data += '&format=' + format;
				}else{
					data.format = format;
				}
			}

			// If data is a string just pass it directly along as is.  Otherwise
			// sort the structured data so that the URL is consistant (for cache
			// busting purposes)
			var sortedDict;
			if (typeof data == 'string') {
				sortedDict = data;
			} else {
				var sortedKeys = [];
				for(var key in data) {
					sortedKeys[sortedKeys.length] = key;
				}
				sortedKeys.sort();
				sortedDict = {};
				for(var i = 0; i < sortedKeys.length; i++) {
					sortedDict[sortedKeys[i]] = data[sortedKeys[i]];
				}
			}

			return $.ajax({
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
					// callback is in data slot, shift parameters
					onErrorCallback = callback;
					callback = data;
					data = {};
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
					// callback is in data slot, shift parameters
					onErrorCallback = callback;
					callback = data;
					data = {};
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
		context.define('wikia.nirvana', ['jquery'], nirvana);
	}

	if(context.jQuery) {
		context.jQuery.nirvana = nirvana(context.jQuery);
	}
}(this));
