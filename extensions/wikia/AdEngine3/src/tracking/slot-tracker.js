import { context, utils } from '@wikia/ad-engine';
import { track } from './tracker';
import targeting from '../targeting';

const onRenderEndedStatusToTrack = [
	'collapse',
	'success',
];
const onChangeStatusToTrack = [
	'blocked',
	'catlapsed',
	'error',
	'viewport-conflict',
];

function getPosParameter({ pos = '' }) {
	return (Array.isArray(pos) ? pos : pos.split(','))[0].toLowerCase();
}

function checkOptIn() {
	if (context.get('options.geoRequiresConsent')) {
		return context.get('options.trackingOptIn') ? 'yes' : 'no';
	}

	return '';
}

function getCurrentScrollY() {
	return window.scrollY || window.pageYOffset;
}

function prepareData(slot, data) {
	const now = new Date();
	const slotName = slot.getSlotName();

	return Object.assign({
		pv: window.pvNumber,
		browser: data.browser,
		country: utils.geoService.getCountryCode(),
		time_bucket: data.time_bucket,
		timestamp: data.timestamp,
		tz_offset: now.getTimezoneOffset(),
		device: context.get('state.deviceType'),
		ad_load_time: data.timestamp - window.performance.timing.connectStart,
		product_lineitem_id: data.line_item_id || '',
		order_id: data.order_id || '',
		creative_id: data.creative_id || '',
		creative_size: data.creative_size || '',
		slot_size: data.creative_size || '',
		ad_status: data.status,
		page_width: data.page_width,
		viewport_height: data.viewport_height,
		kv_skin: context.get('targeting.skin'),
		kv_pos: getPosParameter(slot.getTargeting()),
		kv_wsi: slot.getTargeting().wsi || '',
		kv_rv: slot.getTargeting().rv || '',
		kv_lang: context.get('targeting.lang') || '',
		kv_s0: context.get('targeting.s0'),
		kv_s1: context.get('targeting.s1'),
		kv_s2: context.get('targeting.s2'),
		kv_s0v: context.get('targeting.s0v') || '',
		kv_ah: window.document.body.scrollHeight,
		kv_esrb: context.get('targeting.esrb'),
		kv_ref: context.get('targeting.ref'),
		kv_top: context.get('targeting.top'),
		labrador: utils.geoService.getSamplingResults().join(';'),
		btl: '',
		opt_in: checkOptIn(),
		document_visibility: utils.getDocumentVisibilityStatus(),
		// Missing:
		// page_layout, rabbit, product_chosen
		bidder_won: slot.winningPbBidderDetails ? slot.winningPbBidderDetails.name : '',
		bidder_won_price: slot.winningPbBidderDetails ? slot.winningPbBidderDetails.price : '',
		scroll_y: getCurrentScrollY(),
	}, targeting.getBiddersPrices(slotName));
}

export default {
	isEnabled() {
		return context.get('options.tracking.kikimora.slot');
	},

	onCustomEvent(adSlot, data) {
		track(Object.assign(
			{
				eventName: 'adengadinfo',
				trackingMethod: 'internal',
			},
			prepareData(adSlot, data),
		));
	},

	onRenderEnded(adSlot, data) {
		const status = adSlot.getStatus();

		if (onRenderEndedStatusToTrack.indexOf(status) !== -1 || adSlot.getConfigProperty('trackEachStatus')) {
			track(Object.assign(
				{
					eventName: 'adengadinfo',
					trackingMethod: 'internal',
				},
				prepareData(adSlot, data),
			));
		} else if (status === 'manual') {
			adSlot.trackOnStatusChanged = true;
		}
	},

	onStatusChanged(adSlot, data) {
		const status = adSlot.getStatus();
		const shouldSlotBeTracked = adSlot.getConfigProperty('trackEachStatus') || adSlot.trackOnStatusChanged;

		if (onChangeStatusToTrack.indexOf(status) !== -1 || shouldSlotBeTracked) {
			track(Object.assign(
				{
					eventName: 'adengadinfo',
					trackingMethod: 'internal',
				},
				prepareData(adSlot, data),
			));
			delete adSlot.trackOnStatusChanged;
		}
	},
};
