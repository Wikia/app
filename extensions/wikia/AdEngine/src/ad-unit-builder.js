import Context from 'ad-engine/src/services/context-service';
import StringBuilder from 'ad-engine/src/utils/string-builder';
import {getAdProductInfo} from 'ad-products/src/modules/common/product-info';

export default class AdUnitBuilder {
	static build(slot) {
		const options = slot.config.options;
		const adProductInfo = getAdProductInfo(slot.getSlotName(), options.loadedTemplate, options.loadedProduct);

		return StringBuilder.build(
			Context.get(options.isVideoMegaEnabled ? 'vast.megaAdUnitId' : 'vast.adUnitId'),
			Object.assign(slot.config, adProductInfo)
		);
	}
}
