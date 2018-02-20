/*global define, require*/
define('ext.wikia.adEngine.template.roadblock', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.provider.gpt.helper',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'wikia.document',
	'wikia.log',
	require.optional('ext.wikia.adEngine.template.skin')
], function (
	adContext,
	uapContext,
	btfBlocker,
	gptHelper,
	slotRegistry,
	doc,
	log,
	skinTemplate
) {
	'use strict';

	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.template.roadblock',
		medrecSlotElement = doc.getElementById('TOP_RIGHT_BOXAD'),
		skinSlotElement = doc.getElementById('INVISIBLE_SKIN'),
		uapType = 'ruap';

	function handleMedrec(medrecSlotElement) {
		var medrecSlot = slotRegistry.get(medrecSlotElement.id);

		btfBlocker.unblock(medrecSlot.name);
		log(['handleMedrec', 'unblocking slot', medrecSlot.name], log.levels.info, logGroup);

		if (!context.opts.disableSra) {
			medrecSlotElement.style.opacity = '0';
			gptHelper.refreshSlot(medrecSlot.name);
			medrecSlot.pre('renderEnded', function () {
				medrecSlotElement.style.opacity = '';
			});
			log(['handleMedrec', 'refreshing slot', medrecSlot], log.levels.info, logGroup);
		}
	}

	function handleSkin(skinSlotElement) {
		var skinSlot = slotRegistry.get(skinSlotElement.id);

		btfBlocker.unblock(skinSlot.name);
		log(['handleSkin', 'unblocking slot', skinSlot.name], log.levels.info, logGroup);
	}

	/**
	 * @param {object} params
	 * @param {string} [params.uap] - UAP ATF line item id
	 * @param {object} [params.skin] - skin template params (see skin template for more info)
 	 */
	function show(params) {
		uapContext.setUapId(params.uap);
		uapContext.setType(uapType);

		if (medrecSlotElement) {
			handleMedrec(medrecSlotElement);
		}

		if (skinSlotElement) {
			handleSkin(skinSlotElement);
		}

		log(['show', params.uap], log.levels.info, logGroup);
	}

	return {
		show: show
	};
});
