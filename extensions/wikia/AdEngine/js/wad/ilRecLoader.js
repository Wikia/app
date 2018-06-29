/*global define*/
define('ext.wikia.adEngine.wad.ilRecLoader', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.scriptLoader',
	'wikia.document',
	'wikia.window'
], function (adContext, scriptLoader, doc, win) {
	'use strict';

	var wikiaApiController = 'AdEngine2ApiController',
		wikiaApiMethod = 'getILCode';

	function injectScript() {
		var url = win.wgCdnApiUrl + '/wikia.php?controller=' + wikiaApiController + '&method=' + wikiaApiMethod;

		scriptLoader.loadScript(url, {
			isAsync: false,
			node: doc.head.lastChild
		});
	}

	function init() {
		if (adContext.get('opts.babRecovery')) {
			doc.addEventListener('bab.blocking', injectScript);
		} else {
			injectScript();
		}
	}

	return {
		init: init
	};
});
