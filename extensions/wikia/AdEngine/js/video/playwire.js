/*global define*/
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

	function inject(params) {
		var configUrl = params.configUrl,
			container = params.container,
			height = params.height,
			playerId = 'playwire_' + Math.floor((1 + Math.random()) * 0x10000),
			script = doc.createElement('script'),
			vastUrl = params.vastUrl,
			width = params.width,
			win = container.ownerDocument.defaultView || container.ownerDocument.parentWindow;

		if (!vastUrl) {
			vastUrl = vastUrlBuilder.build(width / height, {
				passback: 'playwire',
				pos: params.slotName,
				src: params.src
			});
		}

		win.onReady = function () {
			params.onReady(win.Bolt, playerId);
		};

		script.setAttribute('data-id', playerId);
		script.setAttribute('data-config', configUrl);
		script.setAttribute('data-ad-tag', vastUrl);

		if (params.onReady) {
			script.setAttribute('data-onready', 'onReady');
		}

		script.setAttribute('type', 'text/javascript');
		script.src = playerUrl;

		container.appendChild(script);
		log(['inject', configUrl], 'debug', logGroup);
	}

	return {
		getConfigUrl: getConfigUrl,
		inject: inject
	};
});
