/**
 * document.write sucks and block the whole page downloading and rendering until it's complete.
 *
 * But for some reason there are still advertisers and ad networks that want to use this
 * obsolete technology.
 *
 * This is why ghostwriter and later postscribe libraries emerged. They let you load a script
 * including document.write calls as it was put in some <div> but without blocking the whole page.
 *
 * ScriptWriter is a wrapper around those libraries which:
 *
 *  * exposes a simple API including two functions: injectScriptByText and injectScriptByUrl
 *  * registers an AMD module wikia.scriptwriter
 *  * chooses library to use (PostScribe if wgUsePostScribe or if PostScribe lib is already loaded)
 *  * loads the library if not already loaded
 *  * works around the "</embed>" bug in PostScribe (https://github.com/krux/postscribe/issues/33)
 *  * launches GhostWriter's flushloadhandlers() trigger after each script handled
 *  * serializes the operation
 *
 * A word on serialization: document.write calls would execute synchronously and that's how some
 * of the 3rd party scripts we run want to be called. We also want as few of those as possible,
 * so adding this additional performance hit makes sure we don't abuse this module.
 *
 * Ideally some day this module should be a simple wrapper around PostScribe.
 */

/*global define, require*/
/*jslint regexp:true*/

define('wikia.scriptwriter', [
	'wikia.document', 'wikia.log', 'wikia.window', 'wikia.loader'
], function (document, log, window, loader) {
	'use strict';

	var module = 'wikia.scriptwriter',
		postscribeLoaded = !!window.postscribe, // we don't want a reference
		library = window.wgUsePostScribe ? 'postscribe' : 'ghostwriter',
		queue = [],
		queueCompleted = false,
		impl,
		implLoading = false, // load implementation only once
		implGw = {},
		implPs = {};

	function escapeHtml(str) {
		return str.replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
	}

	function getElement(elementOrElementId) {
		if (elementOrElementId && elementOrElementId.getElementsByTagName) {
			return elementOrElementId;
		}

		if (typeof elementOrElementId === 'string') {
			var el = document.getElementById(elementOrElementId);
			if (el) {
				return el;
			}
		}

		throw 'wikia.scriptwriter: Not a valid element or element id ' + elementOrElementId;
	}

	function processQueue() {
		log('processQueue', 'debug', module);

		var item, args, callback;

		if (queue.length === 0) {
			queueCompleted = true;
			log(['processQueue', 'Queue completed'], 'debug', module);
			return;
		}

		item = queue[0];
		args = item.args;
		callback = item.callback;

		args.push(function () {
			log(['Done writing', args], 'debug', module);
			if (typeof callback === 'function') {
				log(['Calling done callback', args], 'debug', module);
				callback();
				log(['Done callback called', args], 'debug', module);
			}
			queue.shift();
			log(['processQueue', 'Item processed. Going on'], 'debug', module);
			processQueue();
		});

		log(['Start writing', args], 'debug', module);
		impl[item.type].apply(impl, args);
	}

	function loadImpl() {
		var url;

		if (implLoading) {
			return;
		}
		implLoading = true;

		log('loadImpl ' + library, 'debug', module);

		if (library === 'postscribe') {
			url = '/resources/wikia/libraries/postscribe/postscribe.min.js';
			impl = implPs;

			// GhostWriter does this safety-guards, but PostScribe doesn't
			document.open = document.close = function () {
				return;
			};

			if (postscribeLoaded) {
				log(['loadImpl', 'postscribe already loaded, processing queue'], 'debug', module);
				processQueue();
				return;
			}
		} else {
			url = '/resources/wikia/libraries/ghostwriter/gw.min.js';
			impl = implGw;
		}

		if (loader) {
			loader(url).done(processQueue);
		} else {
			require(['wikia.loader'], function (loader) {
				loader(url).done(processQueue);
			});
		}
	}

	function push(type, args, callback) {
		log(['push', type, args, callback], 'debug', module);

		queue.push({type: type, args: args, callback: callback});

		// In case the queue was already fully processed. Start over
		if (queueCompleted && queue.length === 1) {
			processQueue();
		}

		// Load implementation if needed (it'll start processing the queue)
		loadImpl();
	}

	// PostScribe implementation:

	function psBeforeWrite(str) {
		log(['psBeforeWrite', str], 'trace_l3', module);
		return str.replace(/<\/embed>/gi, '');
	}

	implPs.url = function (element, url, callback) {
		window.postscribe(
			element,
			'<script src="' + escapeHtml(url) + '"></script>',
			{ beforeWrite: psBeforeWrite, done: callback }
		);
	};

	implPs.text = function (element, text, callback) {
		window.postscribe(
			element,
			'<script>' + text + '</script>',
			{ beforeWrite: psBeforeWrite, done: callback }
		);
	};

	// GhostWriter implementation:

	function gwFlushLoadHandlersAndCall(callback) {
		return function () {
			window.ghostwriter.flushloadhandlers();
			callback();
		};
	}

	implGw.url = function (element, url, callback) {
		window.ghostwriter(
			element,
			{
				insertType: 'append',
				script: { src: url },
				done: gwFlushLoadHandlersAndCall(callback)
			}
		);
	};

	implGw.text = function (element, text, callback) {
		window.ghostwriter(
			element,
			{
				insertType: 'append',
				script: { text: text },
				done: gwFlushLoadHandlersAndCall(callback)
			}
		);
	};

	return {
		/**
		 * Inject script to given element and execute any document.write calls.
		 *
		 * @param elementOrElementId element (node or id) to inject the contents to
		 * @param url                script src to inject to the element
		 * @param callback           callback to call on done
		 */
		injectScriptByUrl: function (elementOrElementId, url, callback) {
			push('url', [getElement(elementOrElementId), url], callback);
		},

		/**
		 * Inject script to given element and execute any document.write calls.
		 *
		 * @param elementOrElementId element (node or id) to inject the contents to
		 * @param text               script text to inject to the element
		 * @param callback           callback to call on done
		 */
		injectScriptByText: function (elementOrElementId, text, callback) {
			push('text', [getElement(elementOrElementId), text], callback);
		}
	};
});
