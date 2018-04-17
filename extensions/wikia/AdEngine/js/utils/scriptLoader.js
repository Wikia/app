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

	function loadAsync(src, options) {
		options = options || {};
		options.isAsync = true;

		return loadScript(src, options);
	}

	function loadScript(src, options) {
		options = options || {};

		var script = createScript(src, options.type, options.isAsync, options.node);

		script.onload = options.onLoad;
		script.onerror = options.onError;

		return script;
	}

	return {
		loadAsync: loadAsync,
		loadScript: loadScript
	};
});
