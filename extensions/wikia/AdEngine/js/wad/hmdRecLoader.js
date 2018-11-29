/*global define*/
define('ext.wikia.adEngine.wad.hmdRecLoader', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.scriptLoader',
	'wikia.articleVideo.featuredVideo.adsConfiguration',
	'wikia.document',
	'wikia.querystring',
	'wikia.window'
], function (adContext, scriptLoader, adsConfiguration, doc, qs, win) {
	'use strict';

	var wikiaApiController = 'AdEngine2ApiController',
		wikiaApiMethod = 'getHMDCode',
		isDebug = qs().getVal('hmd-rec-debug', '') === '1',
		configDev = {
			clientConfig: 'https://fabian-test-eu-fra.s3.amazonaws.com/homad/homadConfigTestHttps.json',
			adTag: 'https://fabian-test-eu-fra.s3.amazonaws.com/vast-test-area/vast2-default-5sec.xml'
		},
		configClient = {
			alias: 'comwikiapubadsgdoubleclicknet',
			config: 'https://hgc-cf-cache-1.svonm.com/www.wikia.com/config.json',
			enabled: true,
			server: [
				'https://ssl.1.damoh.wikia.com/[hash]/',
				'https://ssl.2.damoh.wikia.com/[hash]/',
				'https://ssl.3.damoh.wikia.com/[hash]/',
				'https://ssl.4.damoh.wikia.com/[hash]/',
				'https://ssl.5.damoh.wikia.com/[hash]/',
				'https://ssl.6.damoh.wikia.com/[hash]/'
			]
		},
		config = {
			globalConfig: 'https://s3.amazonaws.com/homad-global-configs.schneevonmorgen.com/global_config.json',
			clientConfig: isDebug ? configDev.clientConfig : configClient,
			adTag: isDebug ? configDev.adTag : false,
			prerollAdTag: isDebug ? false : function () {
				console.log('Debug: requesting preroll adTag', adsConfiguration.getCurrentVast('pre'));
				return adsConfiguration.getCurrentVast('pre') || false;
			},
			midrollAdTag: isDebug ? false : function () {
				console.log('Debug: requesting midroll adTag');
				return adsConfiguration.getCurrentVast('mid') || false;
			},
			postrollAdTag: isDebug ? false : function () {
				console.log('Debug: requesting postroll adTag');
				return adsConfiguration.getCurrentVast('post') || false;
			}
		};

	function getConfig() {
		return config;
	}

	function setOnReady(onReady) {
		config.onReady = onReady;
	}

	function injectScript() {
		var url = win.wgCdnApiUrl + '/wikia.php?controller=' + wikiaApiController + '&method=' + wikiaApiMethod + '&cb=2';

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
			injectScript();
		});

		// ToDo: remove debug code
		window.addEventListener('hdEvent', function(event) {
			console.log('Debug: hdEvent', event.detail.name, event);
		});
	}

	return {
		getConfig: getConfig,
		setOnReady: setOnReady,
		init: init
	};
});
