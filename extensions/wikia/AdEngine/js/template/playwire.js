/*global define*/
define('ext.wikia.adEngine.template.playwire', [
	'ext.wikia.adEngine.video.playwire',
	'wikia.log'
], function (player, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.playwire';

	/**
	 * @param {object} params
	 * @param {object} params.container - DOM element where player should be placed
	 * @param {number} params.publisherId - Playwire publisher id (optional if configUrl is passed)
	 * @param {number} params.videoId - Playwire video id (optional if configUrl is passed)
	 * @param {string} [params.configUrl] - URL to Playwire player config
	 * @param {string} [params.vastUrl] - Vast URL (DFP URL with page level targeting will be used if not passed)
	 */
	function show(params) {
		params.configUrl = params.configUrl || player.getConfigUrl(params.publisherId, params.videoId);

		if (params.container) {
			player.inject(params.configUrl, params.container, params.vastUrl);
			log(['show', params.configUrl], 'info', logGroup);
		}
	}

	return {
		show: show
	};
});
