/*global define, Promise*/
define('ext.wikia.adEngine.video.player.playwire', [
	'ext.wikia.adEngine.video.player.playwire.playwirePlayerFactory',
	'ext.wikia.adEngine.video.player.playwire.playwireTracker',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.document',
	'wikia.log'
], function (playerFactory, tracker, vastUrlBuilder, doc, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.playwire',
		playerUrl = '//cdn.playwire.com/bolt/js/zeus/embed.js';

	function getConfigUrl(publisherId, videoId) {
		return '//config.playwire.com/' + publisherId + '/videos/v2/' + videoId + '/zeus.json';
	}

	function inject(params) {
		var configUrl = params.configUrl,
			container = params.container,
			height = params.height,
			playerId = 'playwire_' + Math.floor((1 + Math.random()) * 0x10000),
			script = doc.createElement('script'),
			vastUrlBuilderOptions = {
				useMegaAdUnitBuilder: params.useMegaAdUnitBuilder
			},
			vastUrl = params.vastUrl,
			vastTargeting = params.vastTargeting || {
				passback: 'playwire',
				pos: params.slotName,
				src: params.src
			},
			width = params.width,
			win = container.ownerDocument.defaultView || container.ownerDocument.parentWindow;

		tracker.track(params, 'init');

		return new Promise(function (resolve) {
			configUrl = configUrl || getConfigUrl(params.publisherId, params.videoId);
			vastUrl = vastUrl || vastUrlBuilder.build(width / height, vastTargeting, vastUrlBuilderOptions);

			win[playerId + '_ready'] = function () {
				var video = playerFactory.create(win.Bolt, playerId, params);

				tracker.register(video, params);

				video.addEventListener('boltContentStarted', function () {
					video.api.dispatchEvent(video.id, 'wikiaAdStarted');
				});
				video.addEventListener('boltContentComplete', function () {
					video.api.dispatchEvent(video.id, 'wikiaAdCompleted');
				});

				resolve(video);
				if (params.onReady) {
					params.onReady(win.Bolt, playerId, video);
				}
			};

			script.setAttribute('data-id', playerId);
			script.setAttribute('data-config', configUrl);
			script.setAttribute('data-onready', playerId + '_ready');
			script.setAttribute('data-ad-tag', vastUrl);
			if (params.volume !== undefined) {
				script.setAttribute('data-volume', params.volume);
			}

			script.setAttribute('type', 'text/javascript');
			script.src = playerUrl;

			container.appendChild(script);
			log(['inject', configUrl], log.levels.debug, logGroup);
		});
	}

	return {
		getConfigUrl: getConfigUrl,
		inject: inject
	};
});
