import Context from 'ad-engine/src/services/context-service';
import SlotService from 'ad-engine/src/services/slot-service';
import TemplateService from 'ad-engine/src/services/template-service';
import BigFancyAdBelow from 'ad-products/src/modules/templates/uap/big-fancy-ad-below';
import UniversalAdPackage from 'ad-products/src/modules/templates/uap/universal-ad-package';
import config from './context';

Context.extend(config);
let supportedTemplates = [ BigFancyAdBelow ];

supportedTemplates.forEach((template) => {
	TemplateService.register(template);
});

function init(slotRegistry) {
	SlotService.getBySlotName = (id) => {
		if (id) {
			let slot = slotRegistry.get(id, 'DirectGpt');
			return unifySlotInterface(slot);
		}
	};
}

function unifySlotInterface(slot) {
	slot.getSlotName = () => slot.name;
	slot.getId = () => slot.name;
	slot.config = Context.get(`slot.${slot.name}`) || {targeting: {}};
	return slot;
}

function getSupportedTemplateNames() {
	return supportedTemplates.map((template) => template.getName());
}

function loadCustomAd(fallback) {
	return (params) => {
		if (getSupportedTemplateNames().includes(params.type)) {
			const slot = SlotService.getBySlotName(params.slotName);
			TemplateService.init(params.type, slot, params);
		} else {
			fallback(params);
		}
	};
}

function updatePageLevelTargeting(params) {
	Object.keys(params).forEach((key) => Context.set(`targeting.${key}`, params[key]));
}

export {
	init,
	loadCustomAd,
	UniversalAdPackage,
	updatePageLevelTargeting
};
