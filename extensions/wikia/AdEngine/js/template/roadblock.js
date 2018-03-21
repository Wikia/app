/*global define, require*/
define('ext.wikia.adEngine.template.roadblock', [
	'ext.wikia.adEngine.bridge',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.provider.gpt.helper',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'wikia.document',
	'wikia.log'
], function (
	bridge,
	btfBlocker,
	gptHelper,
	slotRegistry,
	doc,
	log
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.roadblock',
		uapType = 'ruap';

	/**
	 * @param {object} params
	 * @param {string} [params.uap] - UAP ATF line item id
 	 */
	function show(params) {
		var medrecSlot = slotRegistry.get('TOP_RIGHT_BOXAD'),
			skinSlot = slotRegistry.get('INVISIBLE_SKIN');

		bridge.universalAdPackage.setUapId(params.uap);
		bridge.universalAdPackage.setType(uapType);

		if (medrecSlot) {
			btfBlocker.unblock(medrecSlot.name);
			log(['show', 'unblocking slot', medrecSlot.name], log.levels.info, logGroup);
		}

		if (skinSlot) {
			btfBlocker.unblock(skinSlot.name);
			log(['show', 'unblocking slot', skinSlot.name], log.levels.info, logGroup);
		}

		log(['show', params.uap], log.levels.info, logGroup);
	}

	return {
		show: show
	};
});
