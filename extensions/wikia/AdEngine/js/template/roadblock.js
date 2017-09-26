/*global define, require*/
define('ext.wikia.adEngine.template.roadblock', [
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.provider.gpt.helper',
	'ext.wikia.adEngine.provider.gpt.targeting',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.template.skin')
], function (
	uapContext,
	gptHelper,
	targeting,
	slotRegistry,
	doc,
	log,
	win,
	skinTemplate
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.roadblock',
		uapType = 'ruap',
		medrecSlotContainer = doc.getElementById('TOP_RIGHT_BOXAD');

	/**
	 * Handles medrec slot in case of UAP:roadblock
	 * @param {Node} medrecSlotContainer - medrec slot container element
	 * @param {string} uapId - UAP ATF line item ID
	 */
	function handleMedrec(medrecSlotContainer, uapId) {
		var	medrecSlot = slotRegistry.get(medrecSlotContainer.id),
			refreshed = false;

		function onReady() {
			var uapTargetingValue = targeting.getSlotLevelTargetingValue(medrecSlot.name, 'uap'),
				hasCorrectUapId = uapTargetingValue === uapId.toString();

			// refresh once if medrec is not related with UAP:Roadblock
			if (hasCorrectUapId || refreshed) {
				medrecSlotContainer.style.opacity = '';
			} else {
				medrecSlotContainer.style.opacity = '0';
				gptHelper.refreshSlot(medrecSlot.name);
				medrecSlot.pre('renderEnded', onReady);
				refreshed = true;
				log(['handleMedrec', 'refreshing slot', medrecSlot.name], log.levels.info, logGroup);
			}
		}

		onReady();
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

		if (medrecSlotContainer) {
			handleMedrec(medrecSlotContainer, params.uap);
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
