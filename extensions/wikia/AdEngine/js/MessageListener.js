/*global define*/
define('ext.wikia.adEngine.messageListener', [
	'ext.wikia.adEngine.adContext',
	'wikia.log',
	'wikia.window'
], function (adContext, log, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.messageListener',
		callbacks = [],
		unhandledMessages = [];

	function isInterestingMessage(msg) {
		try {
			return !!JSON.parse(msg.data).hasOwnProperty('AdEngine');
		} catch (e) {
			return false;
		}
	}

	function eventMatch(match, msg) {
		var matching = true,
			matchingFrame = false,
			msgFrame;

		if (match.dataKey) {
			matching = JSON.parse(msg.data).AdEngine.hasOwnProperty(match.dataKey);
		}

		if (match.source) {

			// traverse through parents till we get to the current window
			for (msgFrame = msg.source; msgFrame !== window; msgFrame = msgFrame.parent) {
				if (msgFrame === match.source) {
					matchingFrame = true;
				}
			}

			matching = matching && matchingFrame;
		}

		return matching;
	}

	function processMessage(msg) {
		var i, len, callback;
		log(['Received message', msg.data], 'debug', logGroup);

		for (i = 0, len = callbacks.length; i < len; i += 1) {
			callback = callbacks[i];

			if (eventMatch(callback.match, msg)) {
				log(['Event matching', msg, callback], 'debug', logGroup);

				callback.fn(JSON.parse(msg.data).AdEngine);
				if (!callback.match.infinite) {
					callbacks.splice(i, 1);
				}
				return;
			}
		}

		log(['Event not matching (pushed to unhandled messages)', msg], 'debug', logGroup);
		unhandledMessages.push(msg);
	}

	function receiveMessage(msg) {
		if (isInterestingMessage(msg)) {
			processMessage(msg);
		}
	}

	function init() {
		log('Initialized ads message listener', 'debug', logGroup);

		window.addEventListener('message', receiveMessage);
	}

	function register(match, callback) {
		var i, len, msg;

		log(['Register callback', match, callback], 'debug', logGroup);
		for (i = 0, len = unhandledMessages.length; i < len; i += 1) {
			msg = unhandledMessages[i];

			if (eventMatch(match, msg)) {
				unhandledMessages.splice(i, 1);

				log(['Some event matches', msg, callback], 'debug', logGroup);
				callback(JSON.parse(msg.data).AdEngine);

				// Don't add the callback to the list, already handled
				return;
			}
		}

		log(['No events matching (pushing to callbacks)', callback], 'debug', logGroup);

		callbacks.push({match: match, fn: callback});
	}

	adContext.addCallback(function () {
		callbacks = [];
		unhandledMessages = [];
	});

	return {
		init: init,
		register: register
	};
});
