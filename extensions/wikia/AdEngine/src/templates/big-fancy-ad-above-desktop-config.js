import Context from 'ad-engine/src/services/context-service';
import ScrollListener from 'ad-engine/src/listeners/scroll-listener';
import SlotTweaker from 'ad-engine/src/services/slot-tweaker';

import { pinNavbar, navBarElement, navBarStickClass, isElementInViewport } from './navbar-updater';

export function getConfig() {
	return {
		slotsToEnable: [
			'BOTTOM_LEADERBOARD',
			'INCONTENT_BOXAD_1'
		],
		onInit(adSlot, params) {
			Context.set(`slots.${adSlot.getSlotName()}.options.isVideoMegaEnabled`, params.isVideoMegaEnabled);

			const spotlightFooter = document.getElementById('SPOTLIGHT_FOOTER');
			const wrapper = document.getElementById('WikiaTopAds');
			const container = adSlot.getElement();
			const updateNavbar = () => {
				const isSticky = container.classList.contains('sticky-bfaa');
				const isInViewport = isElementInViewport(adSlot, params);

				pinNavbar(isInViewport && !isSticky);
				this.moveNavbar(isSticky ? container.offsetHeight : 0);
			};

			this.slotConfig = params.config;
			wrapper.style.opacity = '0';

			SlotTweaker.onReady(adSlot).then(() => {
				wrapper.style.opacity = '';
				updateNavbar();
			});
			ScrollListener.addCallback(updateNavbar);

			if (!window.ads.runtime.disableCommunitySkinOverride) {
				document.body.classList.add('uap-skin');
			}
			if (spotlightFooter) {
				spotlightFooter.parentNode.style.display = 'none';
			}
		},
		onStickBfaaCallback(adSlot) {
			adSlot.getElement().classList.add('sticky-bfaa');
			pinNavbar(false);
		},
		onUnstickBfaaCallback(adSlot, params) {
			adSlot.getElement().classList.remove('sticky-bfaa');
			pinNavbar(isElementInViewport(adSlot, params));
		},
		moveNavbar(offset) {
			if (navBarElement) {
				navBarElement.style.top = offset ? `${offset}px` : '';
			}
		}
	};
}
