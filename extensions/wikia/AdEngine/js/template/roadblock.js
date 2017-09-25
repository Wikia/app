/*global define, require*/
define('ext.wikia.adEngine.template.roadblock', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.provider.gpt.googleSlots',
	'ext.wikia.adEngine.provider.gpt.helper',
	require.optional('ext.wikia.adEngine.template.skin'),
	'wikia.document',
	'wikia.window',
	'wikia.log'
], function (
	adContext,
	uapContext,
	googleSlots,
	gptHelper,
	skinTemplate,
	doc,
	win,
	log
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.roadblock',
		uapType = 'ruap',
		medrecSlotEl = doc.getElementById('TOP_RIGHT_BOXAD');

	/**
	 * Handles medrec slot in case of UAP:roadblock
	 * @param {Node} medrecSlotEl - medrec slot container element
	 */
	function handleMedrec(medrecSlotEl, uapId) {
		var refreshed = false;

		win.addEventListener('adengine.slot.status', function onAdStatusChange(event) {
			var gptParams = {},
				isMedrec = event.detail.slot.name === medrecSlotEl.id,
				isSuccess = event.detail.adInfo.status === 'success',
				medrecGptSlot = googleSlots.getSlotByName(medrecSlotEl.id);

			if (!isMedrec && !isSuccess) {
				return;
			}

			try {
				gptParams = JSON.parse(doc.getElementById(medrecGptSlot.getSlotElementId()).getAttribute('data-gpt-slot-params'));
			} catch (error) {
				log(['handleMedrec', 'cannot parse GPT params', medrecSlotEl.id], log.levels.error, logGroup);
			}

			// refresh once if medrec is not related with UAP:Roadblock
			if (gptParams.uap !== uapId.toString() && !refreshed) {
				medrecSlotEl.style.opacity = '0';
				gptHelper.refreshSlot(medrecGptSlot);
				refreshed = true;
				log(['handleMedrec', 'refreshing slot', medrecSlotEl.id], log.levels.info, logGroup);
			} else {
				medrecSlotEl.style.opacity = '';
				win.removeEventListener('adengine.slot.status', onAdStatusChange);
			}
		});
	}

	/**
	 * @param {object} params
	 * @param {string} [params.uap] - BFAA line item id
	 * @param {object} [params.skin] - skin template params (see skin template for more info)
 	 */
	function show(params) {
		var isSkinAvailable = params.skin && params.skin.skinImage;

		uapContext.setUapId(params.uap);
		uapContext.setType(uapType);

		if (medrecSlotEl) {
			handleMedrec(medrecSlotEl, params.uap);
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
