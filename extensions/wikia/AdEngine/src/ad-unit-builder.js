import { context, utils } from '@wikia/ad-engine';
import { getAdProductInfo } from '@wikia/ad-engine/dist/ad-products';

export default class AdUnitBuilder {
	static build(slot) {
		const options = slot.config.options;
		const adProductInfo = getAdProductInfo(slot.getSlotName(), options.loadedTemplate, options.loadedProduct);
		let adUnitPattern = context.get(`slots.${slot.getSlotName()}.videoAdUnit`);

		if (!adUnitPattern) {
			adUnitPattern = context.get('vast.megaAdUnitId');
		}

		return utils.stringBuilder.build(adUnitPattern, Object.assign(slot.config, adProductInfo));
	}
}
