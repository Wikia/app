/*global define, Promise*/
define('ext.wikia.adEngine.video.playwire', [
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.document',
	'wikia.log'
], function (vastUrlBuilder, doc, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.playwire',
		playerUrl = '//cdn.playwire.com/bolt/js/zeus/embed.js';

	function getConfigUrl(publisherId, videoId) {
		return '//config.playwire.com/' + publisherId + '/videos/v2/' + videoId + '/zeus.json';
	}

	function getVideo(Bolt, playerId, params) {
		return {
			api: Bolt,
			id: playerId,
			container: params.container,
			addEventListener: function (eventName, callback) {
				this.api.on(this.id, eventName, callback);
			},
			play: function (width, height) {
				this.resize(width, height);
				this.api.playMedia(this.id);
			},
			stop: function () {
				this.api.stopMedia(this.id);
			},
			resize: function (width, height) {
				this.api.resizeVideo(this.id, width + 'px', height + 'px');
			}
		};
	}

	function inject(params) {
		return new Promise(function (resolve) {
			var configUrl = params.configUrl,
				container = params.container,
				height = params.height,
				playerId = 'playwire_' + Math.floor((1 + Math.random()) * 0x10000),
				script = doc.createElement('script'),
				vastUrl = params.vastUrl,
				vastTargeting = params.vastTargeting || {
					passback: 'playwire',
					pos: params.slotName,
					src: params.src
					},
				width = params.width,
				win = container.ownerDocument.defaultView || container.ownerDocument.parentWindow;

			win[playerId + '_ready'] = function () {
				var video = getVideo(win.Bolt, playerId, params);
				resolve(video);
				if (params.onReady) {
					params.onReady(win.Bolt, playerId, video);
				}
			};

			script.setAttribute('data-id', playerId);
			script.setAttribute('data-config', configUrl);
			script.setAttribute('data-onready', playerId + '_ready');
			if (params.volume !== undefined) {
				script.setAttribute('data-volume', params.volume);
			}
			if (!params.disableAds) {
				vastUrl = vastUrl || vastUrlBuilder.build(width / height, vastTargeting);
				script.setAttribute('data-ad-tag', vastUrl);
			}

			script.setAttribute('type', 'text/javascript');
			script.src = playerUrl;

			container.appendChild(script);
			log(['inject', configUrl], 'debug', logGroup);
		});
	}

	return {
		getConfigUrl: getConfigUrl,
		inject: inject
	};
});
