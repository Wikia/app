/*global define, require*/
define('ext.wikia.adEngine.template.roadblock', [
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.provider.gpt.helper',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'wikia.document',
	'wikia.log',
	require.optional('ext.wikia.adEngine.template.skin')
], function (
	uapContext,
	gptHelper,
	slotRegistry,
	doc,
	log,
	skinTemplate
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.roadblock',
		medrecSlotElement = doc.getElementById('TOP_RIGHT_BOXAD'),
		uapType = 'ruap';

	function handleMedrec(medrecSlotElement) {
		var medrecSlot = slotRegistry.get(medrecSlotElement.id);

		medrecSlotElement.style.opacity = '0';
		gptHelper.refreshSlot(medrecSlotElement.id);
		medrecSlot.pre('renderEnded', function () {
			medrecSlotElement.style.opacity = '';
		});
		log(['handleMedrec', 'refreshing slot', medrecSlot], log.levels.info, logGroup);
	}

	/**
	 * @param {object} params
	 * @param {string} [params.uap] - UAP ATF line item id
	 * @param {object} [params.skin] - skin template params (see skin template for more info)
 	 */
	function show(params) {
		var isSkinAvailable = params.skin && params.skin.skinImage;

		uapContext.setUapId(params.uap);
		uapContext.setType(uapType);

		if (medrecSlotElement) {
			handleMedrec(medrecSlotElement);
		}

		if (skinTemplate && isSkinAvailable) {
			log(['show', 'loading skin', params.skin], log.levels.info, logGroup);
			skinTemplate.show(params.skin);
		}

		log(['show', params.uap], log.levels.info, logGroup);
	}

	return {
		show: show
	};
});
