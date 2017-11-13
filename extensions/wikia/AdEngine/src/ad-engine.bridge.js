import Context from 'ad-engine/src/services/context-service';
import SlotService from 'ad-engine/src/services/slot-service';
import TemplateService from 'ad-engine/src/services/template-service';
import BigFancyAdBelow from 'ad-products/src/modules/templates/uap/big-fancy-ad-below';
import UniversalAdPackage from 'ad-products/src/modules/templates/uap/universal-ad-package';
import config from './context';

let blbSlot = {
	config: {
		targeting: {}
	},
	getSlotName: () => 'BOTTOM_LEADERBOARD',
	getId: () => 'BOTTOM_LEADERBOARD'
};

let supportedTemplates = [ BigFancyAdBelow ];

Context.extend(config);

supportedTemplates.forEach((template) => {
	TemplateService.register(template);
});

SlotService.add(blbSlot);

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
	loadCustomAd,
	updatePageLevelTargeting,
	UniversalAdPackage
};
