import Client from 'ad-engine/src/utils/client';
import Context from 'ad-engine/src/services/context-service';
import ScrollListener from 'ad-engine/src/listeners/scroll-listener';
import SlotService from 'ad-engine/src/services/slot-service';
import TemplateService from 'ad-engine/src/services/template-service';
import BigFancyAdBelow from 'ad-products/src/modules/templates/uap/big-fancy-ad-below';
import UniversalAdPackage from 'ad-products/src/modules/templates/uap/universal-ad-package';
import StringBuilder from 'ad-engine/src/utils/string-builder';
import config from './context';

Context.extend(config);
ScrollListener.init();
let supportedTemplates = [ BigFancyAdBelow ];

supportedTemplates.forEach((template) => {
	TemplateService.register(template);
});

function init(slotRegistry, pageLevelTargeting, skin) {
	overrideSlotService(slotRegistry);
	updatePageLevelTargeting(pageLevelTargeting, skin);
}

function overrideSlotService(slotRegistry) {
	SlotService.getBySlotName = (id) => {
		if (id) {
			let slot = slotRegistry.get(id);
			return unifySlotInterface(slot);
		}
	};
}

function unifySlotInterface(slot) {
	const slotContext = Context.get(`slots.${slot.name}`) || {targeting: {}};
	slot.getSlotName = () => slot.name;
	slot.default = {
		getSlotName: () => slot.name
	};
	slot.getId = () => slot.name;
	slot.config = slotContext;
	slot.getVideoAdUnit = () => buildVastAdUnit(slot.name);
	slot.getTargeting = () => slotContext.targeting;
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

function updatePageLevelTargeting(params, skin) {
	Context.set('custom.device', Client.getDeviceType());
	Context.set('targeting.skin', skin);
	Object.keys(params).forEach((key) => Context.set(`targeting.${key}`, params[key]));
}

function setUapId(id) {
	Context.set('targeting.uap', id);
	UniversalAdPackage.setUapId(id);
}

function setType(type) {
	UniversalAdPackage.setType(type);
}

export {
	init,
	loadCustomAd,
	setUapId,
	setType
};
