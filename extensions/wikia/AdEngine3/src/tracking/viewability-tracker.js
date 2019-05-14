import { context } from '@wikia/ad-engine/dist/ad-engine';
import { track } from './tracker';

function prepareData(slot, data) {
	const now = new Date();
	return {
		wsi: slot.getTargeting().wsi || '',
		line_item_id: data.line_item_id,
		creative_id: data.creative_id,
		rv: slot.getTargeting().rv || 1,
		timestamp: data.timestamp,
		tz_offset: now.getTimezoneOffset(),
	};
}

export default {
	isEnabled() {
		return context.get('options.tracking.kikimora.viewability');
	},

	onImpressionViewable(adSlot, data) {
		track(Object.assign(
			{
				eventName: 'adengviewability',
				trackingMethod: 'internal',
			},
			prepareData(adSlot, data),
		));
	},
};
