/*global define, setTimeout*/
define('ext.wikia.adEngine.messageListener', [
	'wikia.log',
	'wikia.window'
], function (log, window) {
	'use strict';

	var callbacks = [],
		unhandledMessages = [];

	function isInterestingMessage(msg) {
		return !!msg.data.AdEngine;
	}

	function eventMatch(match, msg) {
		var matching = true;

		if (match.dataKey) {
			matching = matching && msg.data.AdEngine[match.dataKey];
		}

		if (match.source) {
			matching = matching && msg.source === match.source;
		}

		return matching;
	}

	function receiveMessage(msg) {
		var i, len, callback;

		if (isInterestingMessage(msg)) {

			for (i = 0, len = callbacks.length; i < len; i += 1) {
				callback = callbacks[i];

				if (eventMatch(callback.match, msg)) {
					callback.fn(msg.data.AdEngine);
					callbacks.splice(i, 1);
					return;
				}
			}

			unhandledMessages.push(msg);
		}
	}

	function init() {
		window.addEventListener('message', receiveMessage);
	}

	function register(match, callback) {
		var i, len, msg;

		for (i = 0, len = unhandledMessages.length; i < len; i += 1) {
			msg = unhandledMessages[i];

			if (eventMatch(match, msg)) {
				unhandledMessages.splice(i, 1);

				callback(msg.data.AdEngine);

				// Don't add the callback to the list, already handled
				return;
			}
		}

		callbacks.push({match: match, fn: callback});
	}

	return {
		init: init,
		register: register
	};
});
