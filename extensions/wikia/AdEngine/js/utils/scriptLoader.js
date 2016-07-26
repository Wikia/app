define('ext.wikia.adEngine.utils.scriptLoader', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'wikia.document',
	'wikia.log'
], function (adContext, adTracker, doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.utils.scriptLoader';

	function loadAsync(src, node, type) {
		return loadScript(src, node, type, true);
	}

	function loadScript(src, node, type, isAsync) {
		var script = doc.createElement('script');
		script.async = isAsync || true;
		script.type = type || 'text/javascript';
		script.src = src;
		node.parentNode.insertBefore(script, node);
		log(['Script loaded', src], 'debug', logGroup);
		return script;
	}

	return {
		loadAsync: loadAsync,
		loadScript: loadScript
	};
});
