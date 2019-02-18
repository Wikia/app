import {
	BigFancyAdAbove,
	BigFancyAdBelow,
	PorvataTemplate,
	Roadblock,
	StickyTLB
} from '@wikia/ad-engine/dist/ad-products';
import { templateService } from '@wikia/ad-engine';
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
		templateService.register(PorvataTemplate, getPorvataConfig());
		templateService.register(Roadblock, getRoadblockConfig());
		templateService.register(Skin);
		templateService.register(StickyTLB, getStickyTLBConfig());
	},
};
