import {
	templateService,
	BigFancyAdAbove,
	BigFancyAdBelow,
	FloorAdhesion,
	Interstitial,
	HideOnViewability,
	PorvataTemplate,
	Roadblock,
	StickyTLB
} from '@wikia/ad-engine';
import { getConfig as getBfaaConfig } from './big-fancy-ad-above-config';
import { getConfig as getBfabConfig } from './big-fancy-ad-below-config';
import { getConfig as getPorvataConfig } from './porvata-config';
import { getConfig as getRoadblockConfig } from './roadblock-config';
import { getConfig as getStickyTLBConfig } from './sticky-tlb-config';
import { Skin } from './skin';

export const templateRegistry = {
	registerTemplates() {
		templateService.register(BigFancyAdAbove, getBfaaConfig());
		templateService.register(BigFancyAdBelow, getBfabConfig());
		templateService.register(FloorAdhesion);
		templateService.register(Interstitial);
		templateService.register(HideOnViewability);
		templateService.register(PorvataTemplate, getPorvataConfig());
		templateService.register(Roadblock, getRoadblockConfig());
		templateService.register(Skin);
		templateService.register(StickyTLB, getStickyTLBConfig());
	},
};
