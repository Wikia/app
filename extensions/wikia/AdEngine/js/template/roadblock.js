/*global define, require*/
define('ext.wikia.adEngine.template.roadblock', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.provider.gpt.googleSlots',
	'ext.wikia.adEngine.provider.gpt.helper',
	'ext.wikia.adEngine.template.skin',
	'wikia.log'
], function (
	adContext,
	uapContext,
	btfBlocker,
	googleSlots,
	helper,
	skinTemplate,
	log
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.roadblock',
		uapType = 'roadblock',
		unblockedSlots = [
			'BOTTOM_LEADERBOARD',
			'INCONTENT_BOXAD_1'
		];

	/**
	 * @param {object} params
	 * @param {string} params.backgroundColor - Hex value of background color
	 * @param {string} params.slotName - Slot name key-value needed for VastUrlBuilder
	 * @param {string} [params.uap] - BFAA line item id
	 */
	function show(params) {
		uapContext.setUapId(params.uap);
		uapContext.setType(uapType);

		unblockedSlots.forEach(btfBlocker.unblock);

		if (params.skin && params.skin.skinImage) {
			skinTemplate.show(params.skin);
		}

		log(['show', params.uap, params.skin], log.levels.info, logGroup);
	}

	return {
		show: show
	};
});
