/*global define, require*/
define('ext.wikia.adEngine.template.roadblock', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.provider.gpt.googleSlots',
	'ext.wikia.adEngine.provider.gpt.helper',
	require.optional('ext.wikia.adEngine.template.skin'),
	'ext.wikia.adEngine.slotTweaker',
	'wikia.document',
	'wikia.log'
], function (
	adContext,
	uapContext,
	btfBlocker,
	googleSlots,
	helper,
	skinTemplate,
	slotTweaker,
	doc,
	log
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.roadblock',
		uapType = 'ruap',
		tlbSlot = doc.getElementById('TOP_LEADERBOARD') || doc.getElementById('MOBILE_TOP_LEADERBOARD'),
		medrecSlot = doc.getElementById('TOP_RIGHT_BOXAD'),
		unblockedSlotsNames = [
			'BOTTOM_LEADERBOARD',
			'INCONTENT_PLAYER',
			'INCONTENT_BOXAD_1',
			'INVISIBLE_HIGH_IMPACT_2'
		];

	/**
	 * @param {object} params
	 * @param {string} [params.uap] - BFAA line item id
	 * @param {object} [params.skin] - skin template params (see skin template for more info)
 	 */
	function show(params) {
		var isSkinAvailable = params.skin && params.skin.skinImage;

		uapContext.setUapId(params.uap);
		uapContext.setType(uapType);

		slotTweaker.onReady(tlbSlot.id, function () {
			if (medrecSlot) {
				log(['show', 'refreshing slot', medrecSlot.id], log.levels.info, logGroup);
				helper.refreshSlot(googleSlots.getSlotByName(medrecSlot.id));
			}
		});

		if (isSkinAvailable) {
			log(['show', 'loading skin', params.skin], log.levels.info, logGroup);
			skinTemplate.show(params.skin);
		}

		unblockedSlotsNames.forEach(btfBlocker.unblock);
		log(['show', params.uap], log.levels.info, logGroup);
	}

	return {
		show: show
	};
});
