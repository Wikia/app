import { BigFancyAdAbove, BigFancyAdBelow } from '@wikia/ad-products';
import { slotTweaker, templateService } from '@wikia/ad-engine';

import { getConfig as getMobileBfaaConfig } from './big-fancy-ad-above-mobile-config';
import { getConfig as getDesktopBfaaConfig } from './big-fancy-ad-above-desktop-config';
import { getConfig as getBfabConfig } from './big-fancy-ad-below-config';


export default class TemplateRegistry {
	static init(legacyContext, mercuryListener) {
		const isMobile = legacyContext.get('targeting.skin') !== 'oasis';
		const getBfaaConfig = isMobile ? getMobileBfaaConfig : getDesktopBfaaConfig;

		console.log(getBfaaConfig(mercuryListener));

		templateService.register(BigFancyAdAbove, getBfaaConfig(mercuryListener));
		templateService.register(BigFancyAdBelow, getBfabConfig());
	}
}
