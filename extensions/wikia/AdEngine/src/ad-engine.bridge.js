import Client from 'ad-engine/src/utils/client';
import Context from 'ad-engine/src/services/context-service';
import ScrollListener from 'ad-engine/src/listeners/scroll-listener';
import SlotService from 'ad-engine/src/services/slot-service';
import SlotTweaker from 'ad-engine/src/services/slot-tweaker';
import StringBuilder from 'ad-engine/src/utils/string-builder';
import TemplateService from 'ad-engine/src/services/template-service';
import BigFancyAdAbove from 'ad-products/src/modules/templates/uap/big-fancy-ad-above';
import BigFancyAdBelow from 'ad-products/src/modules/templates/uap/big-fancy-ad-below';
import UniversalAdPackage from 'ad-products/src/modules/templates/uap/universal-ad-package';
import config from './context';
import updateNavbar from './navbar-updater';
import slotConfig from './slots';

Context.extend(config);
let supportedTemplates = [BigFancyAdAbove, BigFancyAdBelow];

TemplateService.register(BigFancyAdAbove, {
	slotsToEnable: [
		'BOTTOM_LEADERBOARD',
		'INCONTENT_BOXAD_1',
	]
});
TemplateService.register(BigFancyAdBelow);

function init(slotRegistry, pageLevelTargeting, legacyContext, legacyBtfBlocker, skin) {
	ScrollListener.addCallback(updateNavbar);
	ScrollListener.init();

	Context.extend({slots: slotConfig[skin]});

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
			SlotTweaker.onReady(slot).then(updateNavbar);
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
