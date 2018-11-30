/*global define*/
define('ext.wikia.adEngine.wad.hmdRecLoader', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'ext.wikia.adEngine.utils.eventDispatcher',
	'ext.wikia.adEngine.utils.scriptLoader',
	'wikia.articleVideo.featuredVideo.adsConfiguration',
	'wikia.document',
	'wikia.log',
	'wikia.querystring',
	'wikia.window'
], function (adContext, slotRegistry, eventDispatcher, scriptLoader, adsConfiguration, doc, log, qs, win) {
	'use strict';

	var wikiaApiController = 'AdEngine2ApiController',
		wikiaApiMethod = 'getHMDCode',
		isDebug = qs().getVal('hmd-rec-debug', '') === '1',
		cacheBuster = 10,
		logGroup = 'wikia.adEngine.wad.hmdRecLoader',
		trackingStatus = {
			hmdSetuped: false,
			adRequested: false,
			hmdErrors: {
				mediaerror: 1001,
				malformattedXML: 1004,
				vastLoadingFailed: 1011,
				noCreative: 1012,
				wrapperLimitReached: 1014
			},
			hmdCollapse: {
				emptyVast: 1003,
				emptyVastFromHomadServerEvent: 1013,
			}
		},
		trackingEventsMap = {
			adRequest: function () {
				trackingStatus.adRequested = true;
				adsConfiguration.trackCustomEvent('hmd_request');
			},
			adImpression: function () {
				adsConfiguration.trackCustomEvent('hmd_impression');
				eventDispatcher.dispatch('adengine.video.status', {
					vastUrl: adsConfiguration.getCurrentVast('last'),
					status: 'success'
				});
			},
			adStart: 'hmd_started',
			// adViewableImpression: 'hmd_viewable_impression',
			adFirstQuartile: 'hmd_first_quartile',
			adMidPoint: 'hmd_midpoint',
			adThirdQuartile: 'hmd_third_quartile',
			adComplete: 'hmd_completed',
			adClick: 'hmd_clicked',
			adSkipped: 'hmd_skipped',
			contentPlayerPlay: 'hmd_content_started',
			contentPlayerPause: function (event) {
				if (event.detail.state === 'setup') {
					trackingStatus.hmdSetuped = true;
					adsConfiguration.trackCustomEvent('hmd_setup');
				} else if (trackingStatus.hmdSetuped) {
					if (trackingStatus.adRequested) {
						trackingStatus.adRequested = false;
						adsConfiguration.trackCustomEvent('hmd_loaded');
					} else {
						adsConfiguration.trackCustomEvent('hmd_ready');
					}
				}
			},
			continueContent: 'hmd_continue',
			penalty: 'hmd_blocked',
			adError: function (event) {
				var type = event.detail.type;

				if (trackingStatus.hmdErrors[type]) {
					adsConfiguration.trackCustomEvent('hmd_error', {
						errorCode: trackingStatus.hmdErrors[type]
					});
				} else if (trackingStatus.hmdCollapse[type]) {
					eventDispatcher.dispatch('adengine.video.status', {
						vastUrl: adsConfiguration.getCurrentVast('last'),
						status: 'collapse'
					});
				}
			}
		},
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
			admessage: 'The ad ends in [time] seconds',
			adjustAdVolumeToContentPlayer: true,
			adTag: isDebug ? configDev.adTag : false,
			prerollAdTag: isDebug ? false : function () {
				log('Requesting preroll adTag', log.levels.info, logGroup);

				return adsConfiguration.getCurrentVast('pre') || false;
			},
			midrollAdTag: isDebug ? false : function () {
				log('Requesting midroll adTag', log.levels.info, logGroup);

				return adsConfiguration.getCurrentVast('mid') || false;
			},
			postrollAdTag: isDebug ? false : function () {
				log('Requesting postroll adTag', log.levels.info, logGroup);

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
		var url = win.wgCdnApiUrl + '/wikia.php?controller=' + wikiaApiController + '&method=' + wikiaApiMethod + '&cb=' + cacheBuster;

		scriptLoader.loadScript(url, {
			isAsync: false,
			node: doc.head.lastChild
		});
	}

	function initializeTracking() {
		window.addEventListener('hdEvent', function(event) {
			log(['HMD event registered', event], log.levels.info, logGroup);

			if (event.detail && event.detail.name && trackingEventsMap[event.detail.name]) {
				var eventName = event.detail.name,
					trackingMethod = trackingEventsMap[eventName];

				if (typeof trackingMethod === 'function') {
					trackingMethod(event);
				} else {
					adsConfiguration.trackCustomEvent(trackingMethod);
				}
			}
		});
	}

	function init() {
		doc.addEventListener('bab.blocking', function () {
			log('Initialising HMD rec loader', log.levels.info, logGroup);

			initializeTracking();
			injectScript();
		});
	}

	return {
		getConfig: getConfig,
		setOnReady: setOnReady,
		init: init
	};
});
