var ScriptWriter = function(log, ghostwriter, document) {
	'use strict';

	var module = 'ScriptWriter'
		, injectScriptByUrl
		, injectScriptByText;

	injectScriptByUrl = function(elementId, url, callback) {
		log('injectScriptByUrl: injecting ' + url + ' to slot: ' + elementId, 5, module);
		ghostwriter(
			document.getElementById(elementId),
			{
				insertType: 'append',
				script: { src: url },
				done: function() {
					log('DONE injectScriptByUrl: (' + url + ' to slot: ' + elementId + ')', 5, module);
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
					ghostwriter.flushloadhandlers();
					if (typeof(callback) === 'function') {
						callback();
					}
				}
			}
		);
	};

	return {
		injectScriptByUrl: injectScriptByUrl,
		injectScriptByText: injectScriptByText
	};
};
