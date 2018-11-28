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

	function getConfig() {
		return {
			globalConfig: "https://s3.amazonaws.com/homad-global-configs.schneevonmorgen.com/global_config.json",
			clientConfig: "https://fabian-test-eu-fra.s3.amazonaws.com/homad/homadConfigTestHttps.json",
			/*clientConfig: function () {
				return {
					"alias": "comwikiapubadsgdoubleclicknet",
					"config": "https://hgc-cf-cache-1.svonm.com/www.wikia.com/config.json",
					"enabled": true,
					"server": [
						"https://ssl.1.damoh.wikia.com/[hash]/",
						"https://ssl.2.damoh.wikia.com/[hash]/",
						"https://ssl.3.damoh.wikia.com/[hash]/",
						"https://ssl.4.damoh.wikia.com/[hash]/",
						"https://ssl.5.damoh.wikia.com/[hash]/",
						"https://ssl.6.damoh.wikia.com/[hash]/"
					]
				};
			},*/
			adTag: 'https://fabian-test-eu-fra.s3.amazonaws.com/vast-test-area/vast2-default-5sec.xml',
			onReady: function () {
				// ToDo: remove debug code
				console.log('Debug: Homad is ready');
			}
		};
	}

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
		getConfig: getConfig,
		init: init
	};
});
