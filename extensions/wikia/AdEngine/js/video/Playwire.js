/*global define*/
define('ext.wikia.adEngine.video.playwire', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.playwire',
		playerUrl = '//cdn.playwire.com/bolt/js/zeus/embed.js';

	function getConfigUrl(publisherId, videoId) {
		return '//config.playwire.com/' + publisherId + '/videos/v2/' + videoId + '/zeus.json';
	}

	function inject(configUrl, parent) {
		var script = doc.createElement('script');

		script.setAttribute('data-config', configUrl);
		script.setAttribute('type', 'text/javascript');
		script.src = playerUrl;

		parent.appendChild(script);
		log(['inject', configUrl], 'debug', logGroup);
	}

	return {
		getConfigUrl: getConfigUrl,
		inject: inject
	};
});
