import { EventEmitter } from 'events';
import {
	client,
	context,
	scrollListener,
	slotListener,
	slotService,
	templateService,
	utils
} from '@wikia/ad-engine';
import {
	BigFancyAdAbove,
	BigFancyAdBelow,
	universalAdPackage
} from '@wikia/ad-products';

import { createTracker } from './tracking/porvata-tracker-factory';
import TemplateRegistry from './templates/templates-registry';
import AdUnitBuilder from './ad-unit-builder';
import config from './context';
import slotConfig from './slots';
import './ad-engine.bridge.scss';

context.extend(config);
let supportedTemplates = [BigFancyAdAbove, BigFancyAdBelow];

function init(
	adTracker,
	geo,
	slotRegistry,
	mercuryListener,
	pageLevelTargeting,
	legacyContext,
	legacyBtfBlocker,
	skin
) {
	TemplateRegistry.init(legacyContext, mercuryListener);
	scrollListener.init();

	context.extend({slots: slotConfig[skin]});
	context.push('listeners.porvata', createTracker(legacyContext, geo, pageLevelTargeting, adTracker));

	overrideSlotService(slotRegistry, legacyBtfBlocker);
	updatePageLevelTargeting(legacyContext, pageLevelTargeting, skin);

	const wikiIdentifier = legacyContext.get('targeting.wikiIsTop1000') ?
		context.get('targeting.s1') : '_not_a_top1k_wiki';

	context.set('custom.wikiIdentifier', wikiIdentifier);
}

function overrideSlotService(slotRegistry, legacyBtfBlocker) {

	const slotsCache = {};

	slotService.getBySlotName = (id) => {
		let slot = slotRegistry.get(id);
		if (id && slot) {
			if (!slotsCache.hasOwnProperty(id)) {
				slotsCache[id] = unifySlotInterface(slot);
			}

			return slotsCache[id];
		}
	};

	slotService.legacyEnabled = slotService.enable;
	slotService.enable = (slotName) => {
		legacyBtfBlocker.unblock(slotName);
	};
}

function unifySlotInterface(slot) {
	const slotContext = context.get(`slots.${slot.name}`) || {targeting: {}};

	slot = Object.assign(new EventEmitter(), slot, {
		config: slotContext,
		default: {
			getSlotName: () => slot.name
		},
		getElement: () => slot.container.parentElement,
		getId: () => slot.name,
		getSlotName: () => slot.name,
		getTargeting: () => slotContext.targeting,
		getVideoAdUnit: () => AdUnitBuilder.build(slot)
	});
	slot.pre('viewed', (event) => {
		slotListener.emitImpressionViewable(event, slot);
	});

	return slot;
}

function loadCustomAd(fallback) {
	return (params) => {
		if (getSupportedTemplateNames().includes(params.type)) {
			const slot = slotService.getBySlotName(params.slotName);
			slot.container.parentNode.classList.add('gpt-ad');

			context.set(`slots.${slot.getSlotName()}.targeting.src`, params.src);
			context.set(`slots.${slot.getSlotName()}.options.loadedTemplate`, params.type);
			context.set(`slots.${slot.getSlotName()}.options.loadedProduct`, params.adProduct);

			templateService.init(params.type, slot, params);
		} else {
			fallback(params);
		}
	};
}

function getSupportedTemplateNames() {
	return supportedTemplates.map((template) => template.getName());
}

function updatePageLevelTargeting(legacyContext, params, skin) {
	context.set('custom.device', utils.client.getDeviceType());
	context.set('targeting.skin', skin);
	context.set('options.video.moatTracking.enabled', legacyContext.get('opts.porvataMoatTrackingEnabled'));
	context.set('options.video.moatTracking.sampling', legacyContext.get('opts.porvataMoatTrackingSampling'));

	Object.keys(params).forEach((key) => context.set(`targeting.${key}`, params[key]));
}

function checkAdBlocking(detection) {
	let adsBlocked = false;

	Client.checkBlocking(() => { adsBlocked = true; });

	detection.initDetection(adsBlocked);
}

export {
	init,
	loadCustomAd,
	checkAdBlocking,
	context,
	universalAdPackage
};
