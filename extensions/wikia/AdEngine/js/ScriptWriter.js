var ScriptWriter = function(log, ghostwriter, document) {
	'use strict';

	var module = 'ScriptWriter'
		, injectScriptByUrl
		, injectScriptByText
		, callLater;

	injectScriptByUrl = function(elementId, url, callback) {
		log('injectScriptByUrl: injecting ' + url + ' to slot: ' + elementId, 5, module);
		ghostwriter(
			document.getElementById(elementId),
			{
				insertType: 'append',
				script: { src: url },
				done: function() {
					log('DONE injectScriptByUrl: (' + url + ' to slot: ' + elementId + ')', 5, module);
					log('ghostwriter.flushloadhandlers()', 1, 'GWFLUSH');
					ghostwriter.flushloadhandlers();
					if (typeof(callback) === 'function') {
						callback();
					}
				}
			}
		);
	};

	injectScriptByText = function(elementId, text, callback) {
		log('injectScriptByText: injecting script ' + text.substr(0, 20) + '... to slot: ' + elementId, 5, module);
		ghostwriter(
			document.getElementById(elementId),
			{
				insertType: 'append',
				script: { text: text },
				done: function() {
					log('DONE injectScriptByText: (' + text.substr(0, 20) + '... to slot: ' + elementId + ')', 5, module);
					log('ghostwriter.flushloadhandlers()', 1, 'GWFLUSH');
					ghostwriter.flushloadhandlers();
					if (typeof(callback) === 'function') {
						callback();
					}
				}
			}
		);
	};

	callLater = function(callback) {
		log('callLater registered', 5, module);
		ghostwriter(
			document.documentElement,
			{
				done: function() {
					ghostwriter.flushloadhandlers();
					if (typeof(callback) === 'function') {
						log('Calling callLater now', 7, module);
						callback();
						log('Actual callLater called', 7, module);
					}
				}
			}
		);
	};

	return {
		injectScriptByUrl: injectScriptByUrl,
		injectScriptByText: injectScriptByText,
		callLater: callLater
	};
};
