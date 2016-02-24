/*global define*/
define('ext.wikia.adEngine.provider.paidAssetDrop', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.paidAssetDrop.paidAssetDrop',
	'wikia.document',
	'wikia.log'
], function (adContext, pad, doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.paidAssetDrop',
		paidAssetDropSlot = 'NATIVE_PAID_ASSET_DROP';

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName, (slotName === paidAssetDropSlot)], 'debug', logGroup);
		return (slotName === paidAssetDropSlot);
	}

	function fillInSlot(slot) {
		var pageType = adContext.getContext().targeting.pageType;
		log(['fillInSlot', slot.name], 'debug', logGroup);

		if (pad.isNowValid(adContext.getContext().opts.paidAssetDropConfig)) {
			pad.injectPAD(slot.container, 'mobile', pageType);
			slot.success();
		} else {
			slot.hop();
		}
	}

	return {
		name: 'PaidAssetDrop',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
