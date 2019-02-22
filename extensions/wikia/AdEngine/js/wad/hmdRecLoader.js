/*global define, require*/
define('ext.wikia.adEngine.wad.hmdRecLoader', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'ext.wikia.adEngine.utils.eventDispatcher',
	'ext.wikia.adEngine.utils.scriptLoader',
	'wikia.document',
	'wikia.log',
	'wikia.querystring',
	'wikia.window',
	require.optional('wikia.articleVideo.featuredVideo.adsConfiguration')
], function (adContext, slotRegistry, eventDispatcher, scriptLoader, doc, log, qs, win, adsConfiguration) {
	'use strict';

	var wikiaApiController = 'AdEngine2ApiController',
		wikiaApiMethod = 'getHMDCode',
		isDebug = qs().getVal('hmd-rec-debug', '') === '1',
		cacheBuster = 10,
		logGroup = 'wikia.adEngine.wad.hmdRecLoader',
		trackingStatus = {
			hmdSetuped: false,
			hmdReady: false,
			adRequested: false,
			adPlayed: false,
			hmdErrors: {
				mediaerror: 1001,
				malformattedXML: 1004,
				vastLoadingFailed: 1011,
				noCreative: 1012,
				wrapperLimitReached: 1014
			},
			hmdCollapse: {
				emptyVast: 1003,
				emptyVastFromHomadServerEvent: 1013
			},
			vastIds: {
				lineItemId: '',
				creativeId: ''
			}
		},
		trackingEventsMap = {
			adRequest: function () {
				trackingStatus.adRequested = true;
				trackingStatus.vastIds.lineItemId = '';
				trackingStatus.vastIds.creativeId = '';
				trackEvent('hmd_request');
			},
			adImpression: function (event) {
				if (event.detail.adIds && event.detail.adIds[0]) {
					var adIds = event.detail.adIds[0];

					if (adIds.adID) {
						trackingStatus.vastIds.lineItemId = adIds.adID;
					}

					if (adIds.creativeID) {
						trackingStatus.vastIds.creativeId = adIds.creativeID;
					}
				}

				trackingStatus.adPlayed = true;

				trackEvent('hmd_impression');
				eventDispatcher.dispatch('adengine.video.status', {
					vastUrl: adsConfiguration.getCurrentVast('last'),
					lineItemId: trackingStatus.vastIds.lineItemId,
					creativeId: trackingStatus.vastIds.creativeId,
					status: 'success'
				});
			},
			adStart: 'hmd_started',
			adFirstQuartile: 'hmd_first_quartile',
			adMidPoint: 'hmd_midpoint',
			adThirdQuartile: 'hmd_third_quartile',
			adComplete: 'hmd_completed',
			adClick: 'hmd_clicked',
			adSkipped: 'hmd_skipped',
			contentPlayerPause: function (event) {
				if (event.detail.state === 'setup') {
					trackingStatus.hmdSetuped = true;
					trackEvent('hmd_setup');
					return;
				}

				if (!trackingStatus.hmdSetuped) {
					return;
				}

				if (!trackingStatus.hmdReady) {
					trackingStatus.hmdReady = true;
					trackEvent('hmd_ready');
					return;
				}

				if (trackingStatus.adRequested) {
					trackingStatus.adRequested = false;
					trackEvent('hmd_loading');
				}
			},
			contentPlayerPlay: function () {
				if (!trackingStatus.adPlayed) {
					trackEvent('hmd_noad');
				}

				trackingStatus.hmdReady = false;
				trackingStatus.adRequested = false;
				trackingStatus.adPlayed = false;
			},
			viewable: 'hmd_viewable_impression',
			penalty: 'hmd_blocked',
			adError: function (event) {
				var type = event.detail.type;

				trackingStatus.adRequested = false;

				if (trackingStatus.hmdErrors[type]) {
					trackEvent('hmd_error', {
						errorCode: trackingStatus.hmdErrors[type]
					});
				} else if (trackingStatus.hmdCollapse[type]) {
					eventDispatcher.dispatch('adengine.video.status', {
						vastUrl: adsConfiguration.getCurrentVast('last'),
						lineItemId: trackingStatus.vastIds.lineItemId,
						creativeId: trackingStatus.vastIds.creativeId,
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
			adTag: false,
			prerollAdTag: function () {
				log('Requesting preroll adTag', log.levels.info, logGroup);

				return isDebug ? configDev.adTag : adsConfiguration.getCurrentVast('pre') || false;
			},
			midrollAdTag: function () {
				log('Requesting midroll adTag', log.levels.info, logGroup);

				return adsConfiguration.getCurrentVast('mid') || false;
			},
			postrollAdTag: function () {
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

	function trackEvent(eventName, params) {
		params = params || {};

		if (trackingStatus.vastIds.lineItemId) {
			params.lineItemId = trackingStatus.vastIds.lineItemId;
		}

		if (trackingStatus.vastIds.creativeId) {
			params.creativeId = trackingStatus.vastIds.creativeId;
		}

		adsConfiguration.trackCustomEvent(eventName, params);
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
			log(['HMD event registered', event, event.detail.name], log.levels.info, logGroup);

			if (
				event.detail && event.detail.name && event.detail.state &&
				['setup', 'preroll'].indexOf(event.detail.state) !== -1 &&
				trackingEventsMap[event.detail.name]
			) {
				var eventName = event.detail.name,
					trackingMethod = trackingEventsMap[eventName];

				if (typeof trackingMethod === 'function') {
					trackingMethod(event);
				} else {
					trackEvent(trackingMethod);
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
