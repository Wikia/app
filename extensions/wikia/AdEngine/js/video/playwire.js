/*global define*/
define('ext.wikia.adEngine.video.playwire', [
	'ext.wikia.adEngine.video.vastBuilder',
	'wikia.document',
	'wikia.log'
], function (vastBuilder, doc, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.playwire',
		playerUrl = '//cdn.playwire.com/bolt/js/zeus/embed.js';

	function getConfigUrl(publisherId, videoId) {
		return '//config.playwire.com/' + publisherId + '/videos/v2/' + videoId + '/zeus.json';
	}

	function inject(configUrl, playerContainer, params) {
		var playerId = 'playwire_' + Math.floor((1 + Math.random()) * 0x10000),
			script = doc.createElement('script'),
			win = playerContainer.ownerDocument.defaultView || playerContainer.ownerDocument.parentWindow;

		if (!params.vastUrl) {
			params.vastUrl = vastBuilder.build();
		}

		win.onReady = function () {
			params.onReady(win.Bolt, playerId);
		};

		script.setAttribute('data-id', playerId);
		script.setAttribute('data-config', configUrl);
		script.setAttribute('data-ad-tag', params.vastUrl);

		if (params.onReady) {
			script.setAttribute('data-onready', 'onReady');
		}

		script.setAttribute('type', 'text/javascript');
		script.src = playerUrl;

		playerContainer.appendChild(script);
		log(['inject', configUrl], 'debug', logGroup);
	}

	return {
		getConfigUrl: getConfigUrl,
		inject: inject
	};
});
