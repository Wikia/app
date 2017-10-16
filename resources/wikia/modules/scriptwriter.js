/**
 * document.write sucks and block the whole page downloading and rendering until it's complete.
 *
 * But for some reason there are still advertisers and ad networks that want to use this
 * obsolete technology.
 *
 * Let you load a script including document.write calls as it was put in some <div> but
 * without blocking the whole page.
 *
 * ScriptWriter is a wrapper around those libraries which:
 *
 *  * exposes a simple API of 3 functions: injectHtml, injectScriptByText and injectScriptByUrl
 *  * registers an AMD module wikia.scriptwriter
 *  * loads the library if not already loaded
 *  * launches GhostWriter's flushloadhandlers() trigger after each script handled
 *  * serializes the operation
 *
 * A word on serialization: document.write calls would execute synchronously and that's how some
 * of the 3rd party scripts we run want to be called. We also want as few of those as possible,
 * so adding this additional performance hit makes sure we don't abuse this module.
 */

/*global define*/
/*jslint regexp:true*/

define('wikia.scriptwriter', [
	'wikia.document', 'wikia.lazyqueue', 'wikia.log', 'wikia.window', 'wikia.loader'
], function (doc, lazyQueue, log, win, loader) {
	'use strict';

	var logGroup = 'wikia.scriptwriter',
		library = 'ghostwriter',
		queue = [],
		loading = false; // load library only once

	function gwFlushLoadHandlersAndCall(callback) {
		return function () {
			win.ghostwriter.flushloadhandlers();
			callback();
		};
	}

	function noop() {
		return;
	}

	/**
	 * Do an HTML injection
	 *
	 * @param {Object}      params
	 * @param {HTMLElement} params.element  Element to inject HTML to
	 * @param {string}      params.html     HTML to inject
	 * @param {Function}    params.callback Function to call when done
	 */
	function processItem(params) {
		log(['processItem', library, params], 'debug', logGroup);

		var text = params.gwScriptText || 'document.write(' + JSON.stringify(params.html) + ');';
		win.ghostwriter(
			params.element,
			{
				insertType: 'append',
				script: { text: text },
				done: gwFlushLoadHandlersAndCall(params.callback)
			}
		);
	}

	function processQueue() {
		log('processQueue', 'debug', logGroup);

		lazyQueue.makeQueue(queue, processItem);
		queue.start();
	}

	function loadLibrary() {
		var url;

		if (loading) {
			return;
		}
		loading = true;

		log(['loadLibrary', library], 'debug', logGroup);
		url = '/resources/wikia/libraries/ghostwriter/gw.min.js';

		loader(url).done(processQueue);
	}

	function getElement(elementOrElementId) {
		if (elementOrElementId && elementOrElementId.getElementsByTagName) {
			return elementOrElementId;
		}

		if (typeof elementOrElementId === 'string') {
			var el = doc.getElementById(elementOrElementId);
			if (el) {
				return el;
			}
		}

		throw 'wikia.scriptwriter: Not a valid element or element id ' + elementOrElementId;
	}

	/**
	 * Queue an HTML injection and load the proper library
	 *
	 * @param {Object}      params
	 * @param {HTMLElement} params.element        Element to inject HTML to
	 * @param {string}      params.html           HTML to inject
	 * @param {string}      [params.gwScriptText] Script to inject (used directly by ghostwriter)
	 * @param {Function}    params.callback       Function to call when done
	 */
	function queueHtmlInjection(params) {
		log(['queueHtmlInjection', params], 'debug', logGroup);

		queue.push(params);

		// Load implementation if needed (it'll start processing the queue)
		loadLibrary();
	}

	function escapeHtml(str) {
		return str.replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
	}

	// Public interface

	/**
	 * Inject HTML to given element and execute any document.write calls.
	 *
	 * @param {(HTMLElement|string)} elementOrElementId element (node or id) to inject the contents to
	 * @param {string}               html               HTML code to inject to the element
	 * @param {Function}             [callback]         callback to call on done
	 */
	function injectHtml(elementOrElementId, html, callback) {
		queueHtmlInjection({
			element: getElement(elementOrElementId),
			html: html,
			callback: callback || noop
		});
	}

	/**
	 * Inject script to given element and execute any document.write calls.
	 *
	 * @param {(HTMLElement|string)} elementOrElementId element (node or id) to inject the contents to
	 * @param {string}               url                script src to inject to the element
	 * @param {Function}             [callback]         callback to call on done
	 */
	function injectScriptByUrl(elementOrElementId, url, callback) {
		queueHtmlInjection({
			element: getElement(elementOrElementId),
			html: '<script src="' + escapeHtml(url) + '"></script>',
			callback: callback || noop
		});
	}

	/**
	 * Inject script to given element and execute any document.write calls.
	 *
	 * @param {(HTMLElement|string)} elementOrElementId element (node or id) to inject the contents to
	 * @param {string}               text               script text to inject to the element
	 * @param {Function}             [callback]         callback to call on done
	 */
	function injectScriptByText(elementOrElementId, text, callback) {
		queueHtmlInjection({
			element: getElement(elementOrElementId),
			html: '<script src="data:text/javascript,' + encodeURIComponent(text) + '"></script>',
			gwScriptText: text, // optimization for GhostWriter
			callback: callback || noop
		});
	}

	return {
		injectHtml: injectHtml,
		injectScriptByUrl: injectScriptByUrl,
		injectScriptByText: injectScriptByText
	};
});
