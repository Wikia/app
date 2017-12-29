import { EventEmitter } from 'events';
import { createTracker } from './tracking/porvata-tracker-factory';
import Client from 'ad-engine/src/utils/client';
import Context from 'ad-engine/src/services/context-service';
import ScrollListener from 'ad-engine/src/listeners/scroll-listener';
import SlotListener from 'ad-engine/src/listeners/slot-listener';
import SlotService from 'ad-engine/src/services/slot-service';
import StringBuilder from 'ad-engine/src/utils/string-builder';
import TemplateRegistry from './templates/templates-registry';
import TemplateService from 'ad-engine/src/services/template-service';
import BigFancyAdAbove from 'ad-products/src/modules/templates/uap/big-fancy-ad-above';
import BigFancyAdBelow from 'ad-products/src/modules/templates/uap/big-fancy-ad-below';
import UniversalAdPackage from 'ad-products/src/modules/templates/uap/universal-ad-package';
import config from './context';
import slotConfig from './slots';
import './ad-engine.bridge.scss';

Context.extend(config);
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
	ScrollListener.init();

	if (skin === 'mercury') {
		Context.set('src', 'mobile');
	}

	Context.extend({slots: slotConfig[skin]});
	Context.push('listeners.porvata', createTracker(legacyContext, geo, pageLevelTargeting, adTracker));

	overrideSlotService(slotRegistry, legacyBtfBlocker);
	updatePageLevelTargeting(legacyContext, pageLevelTargeting, skin);
}

function overrideSlotService(slotRegistry, legacyBtfBlocker) {
	SlotService.getBySlotName = (id) => {
		let slot = slotRegistry.get(id);
		if (id && slot) {
			return unifySlotInterface(slot);
		}
	};

	SlotService.legacyEnabled = SlotService.enable;
	SlotService.enable = (slotName) => {
		legacyBtfBlocker.unblock(slotName);
	};
}

function unifySlotInterface(slot) {
	const slotContext = Context.get(`slots.${slot.name}`) || {targeting: {}};

	slot = Object.assign(new EventEmitter(), slot, {
		config: slotContext,
		default: {
			getSlotName: () => slot.name
		},
		getElement: () => slot.container.parentElement,
		getId: () => slot.name,
		getSlotName: () => slot.name,
		getTargeting: () => slotContext.targeting,
		getVideoAdUnit: () => buildVastAdUnit(slot.name)
	});
	slot.pre('viewed', (event) => {
		SlotListener.emitImpressionViewable(event, slot);
	});

	return slot;
}

function buildVastAdUnit(slotName) {
	return StringBuilder.build(
		Context.get(`vast.adUnitId`),
		Object.assign({}, Context.get('targeting'), Context.get(`slots.${slotName}`))
	);
}

function loadCustomAd(fallback) {
	return (params) => {
		if (getSupportedTemplateNames().includes(params.type)) {
			const slot = SlotService.getBySlotName(params.slotName);
			slot.container.parentNode.classList.add('gpt-ad');
			Context.set(`slots.${params.slotName}.targeting.src`, params.src);
			TemplateService.init(params.type, slot, params);
		} else {
			fallback(params);
		}
	};
}

function getSupportedTemplateNames() {
	return supportedTemplates.map((template) => template.getName());
}

function updatePageLevelTargeting(legacyContext, params, skin) {
	Context.set('custom.device', Client.getDeviceType());
	Context.set('targeting.skin', skin);
	Context.set('options.video.moatTracking.enabled', legacyContext.get('opts.porvataMoatTrackingEnabled'));
	Context.set('options.video.moatTracking.sampling', legacyContext.get('opts.porvataMoatTrackingSampling'));

	Object.keys(params).forEach((key) => Context.set(`targeting.${key}`, params[key]));
}

export {
	init,
	loadCustomAd,
	Context,
	UniversalAdPackage
};
