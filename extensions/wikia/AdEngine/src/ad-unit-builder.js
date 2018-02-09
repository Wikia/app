import { context, utils } from '@wikia/ad-engine';
import { getAdProductInfo } from '@wikia/ad-products';

export default class AdUnitBuilder {
	static build(slot) {
		const options = slot.config.options;
		const adProductInfo = getAdProductInfo(slot.getSlotName(), options.loadedTemplate, options.loadedProduct);

		return utils.stringBuilder.build(
			context.get(options.isVideoMegaEnabled ? 'vast.megaAdUnitId' : 'vast.adUnitId'),
			Object.assign(slot.config, adProductInfo)
		);
	}
}
