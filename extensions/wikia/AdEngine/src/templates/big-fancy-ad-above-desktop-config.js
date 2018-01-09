import { context, scrollListener, slotTweaker } from '@wikia/ad-engine';
import { updateNavbar, navBarElement } from './navbar-updater';

export function getConfig() {
	return {
		slotsToEnable: [
			'BOTTOM_LEADERBOARD',
			'INCONTENT_BOXAD_1'
		],
		onInit(adSlot, params) {
			context.set(`slots.${adSlot.getSlotName()}.options.isVideoMegaEnabled`, params.isVideoMegaEnabled);

			const spotlightFooter = document.getElementById('SPOTLIGHT_FOOTER');
			const wrapper = document.getElementById('WikiaTopAds');

			wrapper.style.opacity = '0';
			slotTweaker.onReady(adSlot).then(() => {
				wrapper.style.opacity = '';
				updateNavbar(params.config);
				this.moveNavbar(adSlot.getElement().offsetHeight);
			});
			scrollListener.addCallback(() => {
				updateNavbar(params.config);
			});

			if (!window.ads.runtime.disableCommunitySkinOverride) {
				document.body.classList.add('uap-skin');
			}
			if (spotlightFooter) {
				spotlightFooter.parentNode.style.display = 'none';
			}
		},
		onStickBfaaCallback(adSlot) {
			adSlot.getElement().classList.add('sticky-bfaa');
			navBarElement.style.position = 'fixed';
		},
		onUnstickBfaaCallback(adSlot) {
			adSlot.getElement().classList.remove('sticky-bfaa');
			navBarElement.style.position = '';
		},
		moveNavbar(offset) {
			if (navBarElement) {
				navBarElement.style.top = offset ? `${offset}px` : '';
			}
		}
	};
}
