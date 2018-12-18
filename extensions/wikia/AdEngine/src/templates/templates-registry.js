import {
	BigFancyAdAbove,
	BigFancyAdBelow,
	BigFancyAdInPlayer,
	Roadblock,
	StickyTLB,
} from '@wikia/ad-engine/dist/ad-products';
import { slotTweaker, templateService } from '@wikia/ad-engine';

import { getConfig as getMobileBfaaConfig } from './big-fancy-ad-above-mobile-config';
import { getConfig as getDesktopBfaaConfig } from './big-fancy-ad-above-desktop-config';
import { getConfig as getMobileBfpConfig } from './big-fancy-ad-in-player-mobile-config';
import { getConfig as getDesktopBfpConfig } from './big-fancy-ad-in-player-desktop-config';
import { getConfig as getDesktopBfabConfig } from './big-fancy-ad-below-desktop-config';
import { getConfig as getMobileBfabConfig } from './big-fancy-ad-below-mobile-config';
import { getConfig as getDesktopRoadblockConfig } from './roadblock-desktop-config';
import { getConfig as getMobileRoadblockConfig } from './roadblock-mobile-config';
import { getConfig as getDesktopStickyTLBConfig } from './sticky-tlb-desktop-config';

export default class TemplateRegistry {
	static init(legacyContext, mercuryListener) {
		const isMobile = legacyContext.get('targeting.skin') !== 'oasis';
		const getBfaaConfig = isMobile ? getMobileBfaaConfig : getDesktopBfaaConfig;
		const getBfabConfig = isMobile ? getMobileBfabConfig : getDesktopBfabConfig;
		const getBfpConfig = isMobile ? getMobileBfpConfig : getDesktopBfpConfig;
		const getRoadblockConfig = isMobile ? getMobileRoadblockConfig : getDesktopRoadblockConfig;

		templateService.register(BigFancyAdAbove, getBfaaConfig(mercuryListener));
		templateService.register(BigFancyAdBelow, getBfabConfig());
		templateService.register(BigFancyAdInPlayer, getBfpConfig());
		templateService.register(Roadblock, getRoadblockConfig());

		if (!isMobile) {
			templateService.register(StickyTLB, getDesktopStickyTLBConfig());
		}
	}
}
