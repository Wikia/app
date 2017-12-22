import Context from 'ad-engine/src/services/context-service';
import StringBuilder from 'ad-engine/src/utils/string-builder';

const groupMapping = {
	LB: ['TOP_LEADERBOARD', 'MOBILE_TOP_LEADERBOARD'],
	MR: ['TOP_RIGHT_BOXAD'],
	PF: ['MOBILE_PREFOOTER', 'BOTTOM_LEADERBOARD', 'MOBILE_BOTTOM_LEADERBOARD'],
	PX: ['INVISIBLE_SKIN', 'INVISIBLE_HIGH_IMPACT', 'INVISIBLE_HIGH_IMPACT_2'],
	HiVi: ['INCONTENT_BOXAD_1', 'MOBILE_IN_CONTENT'],
	VIDEO: ['FEATURED', 'OUTSTREAM', 'UAP_BFAA', 'UAP_BFAB', 'ABCD', 'OOYALA', 'VIDEO']
};

function findSlotGroup(product) {
	var result = Object.keys(groupMapping).filter(function (name) {
		return groupMapping[name].indexOf(product) !== -1;
	});

	return result.length === 1 ? result[0] : null;
}

function getGroup(product) {
	return findSlotGroup(product.toUpperCase()) || 'OTHER';
}

function getAdProductInfo(slotName, loadedTemplate, loadedProduct) {
	let product = slotName;

	if (loadedProduct === 'abcd') {
		product = 'ABCD';
	} else if (loadedProduct === 'vuap') {
		product = `UAP_${loadedTemplate.toUpperCase()}`;
	}

	return {
		adGroup: getGroup(product),
		adProduct: product.toLowerCase()
	};
}

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
