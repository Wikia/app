/*global define*/
define('ext.wikia.adEngine.provider.paidAssetDrop', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.paidAssetDrop.paidAssetDrop',
	'wikia.log'
], function (adContext, pad, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.liftium',
		paidAssetDropSlot = 'NATIVE_PAID_ASSET_DROP',
		paidAssetDropSlotLoaded = false; // Only insert the PAD once

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName, (slotName === paidAssetDropSlot)], 'debug', logGroup);
		return (slotName === paidAssetDropSlot);
	}

	function fillInSlot(slotName, success, hop) {
		log(['fillInSlot', slotName], 'debug', logGroup);

		if (pad.isNowValid(adContext.getContext().opts.paidAssetDropConfig)) {
			if (!paidAssetDropSlotLoaded) {
				pad.injectPAD('#' + slotName, 'mobile');
				paidAssetDropSlotLoaded = true;
			}
			success();
		} else {
			hop();
		}
	}

	return {
		name: 'PaidAssetDrop',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
