import { context } from '@wikia/ad-engine';

export function getConfig() {
	return {
		onInit(adSlot, params) {
			context.set(`slots.${adSlot.getSlotName()}.options.isVideoMegaEnabled`, params.isVideoMegaEnabled);
		}
	};
}
