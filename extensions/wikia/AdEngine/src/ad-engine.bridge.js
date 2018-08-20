import { EventEmitter } from 'events';
import {
	client,
	context,
	GptSizeMap,
	scrollListener,
	slotListener,
	slotService,
	templateService,
	utils
} from '@wikia/ad-engine';
import {
	BigFancyAdAbove,
	BigFancyAdBelow,
	BigFancyAdInPlayer,
	billTheLizard,
	universalAdPackage,
	isProperGeo,
	getSamplingResults,
	utils as adProductsUtils
} from '@wikia/ad-products';

import { createTracker } from './tracking/porvata-tracker-factory';
import TemplateRegistry from './templates/templates-registry';
import AdUnitBuilder from './ad-unit-builder';
import config from './context';
import { getSlotsContext } from './slots';
import './ad-engine.bridge.scss';

context.extend(config);

const supportedTemplates = [BigFancyAdAbove, BigFancyAdBelow, BigFancyAdInPlayer];

function init(
	adTracker,
	geo,
	slotRegistry,
	mercuryListener,
	pageLevelTargeting,
	legacyContext,
	legacyBtfBlocker,
	skin,
	trackingOptIn
) {
	const isOptedIn = trackingOptIn.isOptedIn();

	const bfabStickiness = legacyContext.get('opts.areMobileStickyAndSwapEnabled') ||
		legacyContext.get('opts.isDesktopBfabStickinessEnabled');
	context.set('options.bfabStickiness', bfabStickiness);

	TemplateRegistry.init(legacyContext, mercuryListener);
	scrollListener.init();

	context.set('slots', getSlotsContext(legacyContext, skin));
	context.push('listeners.porvata', createTracker(legacyContext, geo, pageLevelTargeting, adTracker));
	context.set('options.trackingOptIn', isOptedIn);
	adProductsUtils.setupNpaContext();

	overrideSlotService(slotRegistry, legacyBtfBlocker);
	updatePageLevelTargeting(legacyContext, pageLevelTargeting, skin);
	syncSlotsStatus(slotRegistry, context.get('slots'));

	const wikiIdentifier = legacyContext.get('targeting.wikiIsTop1000') ?
		context.get('targeting.s1') : '_not_a_top1k_wiki';

	context.set('custom.wikiIdentifier', wikiIdentifier);
	context.set('options.contentLanguage', window.wgContentLanguage);

	legacyContext.addCallback(() => {
		context.set('slots', getSlotsContext(legacyContext, skin));
		syncSlotsStatus(slotRegistry, context.get('slots'));
	});
}

function overrideSlotService(slotRegistry, legacyBtfBlocker) {
	const slotsCache = {};

	slotService.get = (slotName) => {
		let slot = slotRegistry.get(slotName);
		if (slotName && slot) {
			if (!slotsCache.hasOwnProperty(slotName)) {
				slotsCache[slotName] = unifySlotInterface(slot);
			}

			return slotsCache[slotName];
		}
	};

	slotService.clearSlot = (slotName) => {
		delete slotsCache[slotName];
	};

	slotService.legacyEnabled = slotService.enable;
	slotService.enable = (slotName) => {
		legacyBtfBlocker.unblock(slotName);
		slotRegistry.enable(slotName);
	};
	slotService.disable = (slotName) => {
		slotRegistry.disable(slotName);
	};
}

function syncSlotsStatus(slotRegistry, slotsInContext) {
	for (let slot in slotsInContext) {
		if (slotsInContext[slot].disabled) {
			slotRegistry.disable(slot);
		}
	}
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
		getVideoAdUnit: () => AdUnitBuilder.build(slot),
		getViewportConflicts: () => {
			return slotContext.viewportConflicts || [];
		},
		hasDefinedViewportConflicts: () => {
			return (slotContext.viewportConflicts || []).length > 0;
		},
		isRepeatable: () => false,
		setConfigProperty: (key, value) => {
			context.set(`slots.${slot.name}.${key}`, value);
		},
		getStatus: () => null,
		setStatus: (status) => {
			if (status === 'viewport-conflict') {
				const event = document.createEvent('CustomEvent');
				event.initCustomEvent('adengine.slot.status', true, true, {
					slot: slot,
					status: status
				});
				window.dispatchEvent(event);
			}
		}
	});

	slot.pre('viewed', (event) => {
		slotListener.emitImpressionViewable(event, slot);
	});

	return slot;
}

function loadCustomAd(fallback) {
	return (params) => {
		const isTemplateSupported = getSupportedTemplateNames().includes(params.type);

		if (isTemplateSupported && params.slotName) {
			if (params.slotName.indexOf(',') !== -1) {
				params.slotName = params.slotName.split(',')[0];
			}

			const slot = slotService.get(params.slotName);
			slot.container.parentNode.classList.add('gpt-ad');

			context.set(`slots.${slot.getSlotName()}.targeting.src`, params.src);
			context.set(`slots.${slot.getSlotName()}.options.loadedTemplate`, params.type);
			context.set(`slots.${slot.getSlotName()}.options.loadedProduct`, params.adProduct);

			templateService.init(params.type, slot, params);
		} else if (isTemplateSupported) {
			templateService.init(params.type, null, params);
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
	context.set('options.video.moatTracking.sampling', legacyContext.get('opts.porvataMoatTrackingSampling'));
	context.set('options.video.moatTracking.enabled', legacyContext.get('opts.porvataMoatTrackingEnabled'));

	Object.keys(params).forEach((key) => context.set(`targeting.${key}`, params[key]));
}

function checkAdBlocking(detection) {
	utils.client.checkBlocking(
		() => { detection.initDetection(true); },
		() => { detection.initDetection(false); }
	);
}

function passSlotEvent(slotName, eventName) {
	slotService.get(slotName).emit(eventName);
}

export {
	billTheLizard,
	init,
	GptSizeMap,
	loadCustomAd,
	checkAdBlocking,
	passSlotEvent,
	context,
	universalAdPackage,
	isProperGeo,
	getSamplingResults,
	slotService
};
