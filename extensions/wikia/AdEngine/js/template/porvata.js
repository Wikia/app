/*global define*/
define('ext.wikia.adEngine.template.porvata', [
	'ext.wikia.adEngine.video.player.porvata'
], function (porvata) {
	'use strict';

	/**
	 * @param {object} params
	 * @param {object} params.container - DOM element where player should be placed
	 * @param {object} params.slotName - Slot name key-value needed for VastUrlBuilder
	 * @param {object} params.src - SRC key-value needed for VastUrlBuilder
	 * @param {object} params.width - Player width
	 * @param {object} params.height - Player height
	 * @param {string} [params.onReady] - Callback executed once player is ready
	 * @param {string} [params.vastUrl] - Vast URL (DFP URL with page level targeting will be used if not passed)
	 */
	function show(params) {
		porvata.inject(params);
	}

	return {
		show: show
	};
});
