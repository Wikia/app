import Context from 'ad-engine/src/services/context-service';

export function getConfig() {
	return {
		onInit(adSlot, params) {
			Context.set(`slots.${adSlot.getSlotName()}.options.isVideoMegaEnabled`, params.isVideoMegaEnabled);
		}
	};
}
