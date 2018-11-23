/*global define*/
define('ext.wikia.adEngine.wad.hmdRecLoader', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.scriptLoader',
	'wikia.document',
	'wikia.window'
], function (adContext, scriptLoader, doc, win) {
	'use strict';

	var wikiaApiController = 'AdEngine2ApiController',
		wikiaApiMethod = 'getHMDCode';

	function injectScript() {
		var url = win.wgCdnApiUrl + '/wikia.php?controller=' + wikiaApiController + '&method=' + wikiaApiMethod;

		scriptLoader.loadScript(url, {
			isAsync: false,
			node: doc.head.lastChild
		});
	}

	function init() {
		//doc.addEventListener('bab.blocking', injectScript);

		// ToDo: remove debug code
		doc.addEventListener('bab.blocking', function () {
			console.log('Debug: blocking detected');
		});

		// ToDo: remove debug code
		injectScript();

		// ToDo: remove debug code
		window.addEventListener('hdEvent', function(event) {
			console.log('Debug: hdEvent', event);
		});
	}

	return {
		init: init
	};
});
