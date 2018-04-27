import { BigFancyAdAbove, BigFancyAdBelow, BigFancyAdInPlayer } from '@wikia/ad-products';
import { slotTweaker, templateService } from '@wikia/ad-engine';

import { getConfig as getMobileBfaaConfig } from './big-fancy-ad-above-mobile-config';
import { getConfig as getDesktopBfaaConfig } from './big-fancy-ad-above-desktop-config';
import { getConfig as getMobileBfpConfig } from './big-fancy-ad-in-player-mobile-config';
import { getConfig as getDesktopBfpConfig } from './big-fancy-ad-in-player-desktop-config';
import { getConfig as getBfabConfig } from './big-fancy-ad-below-config';


export default class TemplateRegistry {
	static init(legacyContext, mercuryListener) {
		const isMobile = legacyContext.get('targeting.skin') !== 'oasis';
		const getBfaaConfig = isMobile ? getMobileBfaaConfig : getDesktopBfaaConfig;
		const getBfpConfig = isMobile ? getMobileBfpConfig : getDesktopBfpConfig;

		templateService.register(BigFancyAdAbove, getBfaaConfig(mercuryListener));
		templateService.register(BigFancyAdBelow, getBfabConfig());
		templateService.register(BigFancyAdInPlayer, getBfpConfig());
	}
}
