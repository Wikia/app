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

	function inject(params) {
		var container = params.container,
			height = params.height,
			script = doc.createElement('script'),
			slotName = params.slotName,
			vastUrl = params.vastUrl,
			width = params.width,
			configUrl = params.configUrl;

		if (!vastUrl) {
			vastUrl = vastBuilder.build('playwire', slotName, width / height);
		}

		script.setAttribute('data-config', configUrl);
		script.setAttribute('data-ad-tag', vastUrl);

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
