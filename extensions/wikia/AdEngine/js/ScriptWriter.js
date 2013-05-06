/*global define*/
define('ad.scriptwriter', ['wikia.document', 'wikia.log', 'wikia.window'], function (document, log, window) {
	'use strict';

	var logGroup = 'ScriptWriter',
		abTest = window.Wikia.AbTest,
		ghostwriter = window.ghostwriter,
		postscribe = window.postscribe,
		useGw = !abTest.inGroup('GHOSTWRITER_VS_POSTSCRIBE', 'POSTSCRIBE'),
		impl = {};

	function escapeHtml(s) {
		return s.replace(/\&/g, '&amp;').replace(/</g, '&lt;')
			.replace(/>/g, '&gt;').replace(/\'/g, '&apos;').replace(/\"/g, '&quot;');
	}

	if (useGw) {
		log('Using GhostWriter as ScriptWriter implementation', 3, logGroup);
		impl.injectScriptByUrl = function (elementId, url, callback) {
			log('injectScriptByUrl: injecting ' + url + ' to slot: ' + elementId, 5, logGroup);
			ghostwriter(
				document.getElementById(elementId),
				{
					insertType: 'append',
					script: { src: url },
					done: function () {
						log('DONE injectScriptByUrl: (' + url + ' to slot: ' + elementId + ')', 5, logGroup);
						ghostwriter.flushloadhandlers();
						if (typeof callback === 'function') {
							callback();
						}
					}
				}
			);
		};

		impl.injectScriptByText = function (elementId, text, callback) {
			log('injectScriptByText: injecting script ' + text.substr(0, 20) + '... to slot: ' + elementId, 5, logGroup);
			ghostwriter(
				document.getElementById(elementId),
				{
					insertType: 'append',
					script: { text: text },
					done: function () {
						log('DONE injectScriptByText: (' + text.substr(0, 20) + '... to slot: ' + elementId + ')', 5, logGroup);
						ghostwriter.flushloadhandlers();
						if (typeof callback === 'function') {
							callback();
						}
					}
				}
			);
		};

		impl.callLater = function (callback) {
			log('callLater registered', 5, logGroup);
			ghostwriter(
				document.documentElement,
				{
					done: function () {
						ghostwriter.flushloadhandlers();
						if (typeof callback === 'function') {
							log('Calling callLater now', 7, logGroup);
							callback();
							log('Actual callLater called', 7, logGroup);
						}
					}
				}
			);
		};
	} else {
		log('Using PostScribe as ScriptWriter implementation', 3, logGroup);
		impl.injectScriptByUrl = function (elementId, url, callback) {
			log('injectScriptByUrl: injecting ' + url + ' to slot: ' + elementId, 5, logGroup);
			postscribe(
				document.getElementById(elementId),
				'<script src="' + escapeHtml(url) + '"></script>',
				{
					done: function () {
						log('DONE injectScriptByUrl: (' + url + ' to slot: ' + elementId + ')', 5, logGroup);
						if (typeof callback === 'function') {
							callback();
						}
					},
					error: function (e) {
						log(['ERROR', 'injectScriptByUrl', url, elementId, e], 1, logGroup);
					}
				}
			);
		};
		impl.injectScriptByText = function (elementId, text, callback) {
			log('injectScriptByText: injecting script ' + text.substr(0, 20) + '... to slot: ' + elementId, 5, logGroup);
			postscribe(
				document.getElementById(elementId),
				'<script>' + text + '</script>',
				{
					done: function () {
						log('DONE injectScriptByText: (' + text.substr(0, 20) + '... to slot: ' + elementId + ')', 5, logGroup);
						if (typeof callback === 'function') {
							callback();
						}
					},
					error: function (e) {
						log(['ERROR', 'injectScriptByText', text.substr(0, 20) + '...', elementId, e], 1, logGroup);
					}
				}
			);
		};
		impl.callLater = function (callback) {
			log('callLater registered', 5, logGroup);
			if (typeof callback === 'function') {
				log('Calling callLater now', 7, logGroup);
				callback();
				log('Actual callLater called', 7, logGroup);
			}
		};
	}

	return impl;
});
