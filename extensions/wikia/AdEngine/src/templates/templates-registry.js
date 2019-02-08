import {
	BigFancyAdAbove,
	BigFancyAdBelow,
	BigFancyAdInPlayer,
	PorvataTemplate,
	Roadblock,
	StickyTLB,
} from '@wikia/ad-engine/dist/ad-products';
import { slotTweaker, templateService } from '@wikia/ad-engine';

import { getConfig as getBfaaConfig } from './big-fancy-ad-above-config';
import { getConfig as getBfpConfig } from './big-fancy-ad-in-player-config';
import { getConfig as getBfabConfig } from './big-fancy-ad-below-config';
import { getConfig as getPorvataConfig } from './porvata-config';
import { getConfig as getRoadblockConfig } from './roadblock-config';
import { getConfig as getStickyTLBConfig } from './sticky-tlb-config';

export default class TemplateRegistry {
	static init(floater) {
		templateService.register(BigFancyAdAbove, getBfaaConfig());
		templateService.register(BigFancyAdBelow, getBfabConfig());
		templateService.register(BigFancyAdInPlayer, getBfpConfig());
		templateService.register(PorvataTemplate, getPorvataConfig(floater));
		templateService.register(Roadblock, getRoadblockConfig());
		templateService.register(StickyTLB, getStickyTLBConfig());
	}
}
