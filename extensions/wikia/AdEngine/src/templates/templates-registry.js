import BigFancyAdAbove from 'ad-products/src/modules/templates/uap/big-fancy-ad-above';
import BigFancyAdBelow from 'ad-products/src/modules/templates/uap/big-fancy-ad-below';
import SlotTweaker from 'ad-engine/src/services/slot-tweaker';
import TemplateService from 'ad-engine/src/services/template-service';

import { getConfig as getMobileBfaaConfig } from './big-fancy-ad-above-mobile-config';
import { getConfig as getDesktopBfaaConfig } from './big-fancy-ad-above-desktop-config';


export default class TemplateRegistry {
	static init(legacyContext) {
		const isMobile = legacyContext.get('targeting.skin') !== 'oasis';

		TemplateService.register(BigFancyAdAbove, isMobile ? getMobileBfaaConfig() : getDesktopBfaaConfig());
		TemplateService.register(BigFancyAdBelow);
	}
}
