/*global define, Promise*/
define('ext.wikia.adEngine.utils.scriptLoader', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'wikia.document',
], function (adContext, adTracker, doc) {
	'use strict';

	function createScript(src, type, isAsync, node) {
		var script = doc.createElement('script');

		node = node || doc.body.lastChild;
		script.async = isAsync || true;
		script.type = type || 'text/javascript';
		script.src = src;
		node.parentNode.insertBefore(script, node);

		return script;
	}

	function loadAsync(src, node, type) {
		return loadScript(src, type, true, node);
	}

	function loadScript(src, type, isAsync, node) {
		return new Promise(function (resolve, reject) {
			var script = createScript(src, type, isAsync, node);
			script.onload = resolve;
			script.onerror = reject;
		});
	}

	return {
		loadAsync: loadAsync,
		loadScript: loadScript
	};
});
