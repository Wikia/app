import ScrollListener from 'ad-engine/src/listeners/scroll-listener';
import SlotTweaker from 'ad-engine/src/services/slot-tweaker';
import updateNavbar from './navbar-updater';

export function getConfig() {
	return {
		slotsToEnable: [
			'BOTTOM_LEADERBOARD',
			'INCONTENT_BOXAD_1'
		],
		onInit(adSlot, params) {
			const spotlightFooter = document.getElementById('SPOTLIGHT_FOOTER');
			const wrapper = document.getElementById('WikiaTopAds');

			wrapper.style.opacity = '0';
			SlotTweaker.onReady(adSlot).then(() => {
				wrapper.style.opacity = '';
				updateNavbar(params.config);
			});
			ScrollListener.addCallback(() => {
				updateNavbar(params.config);
			});

			if (!window.ads.runtime.disableCommunitySkinOverride) {
				document.body.classList.add('uap-skin');
			}
			if (spotlightFooter) {
				spotlightFooter.parentNode.style.display = 'none';
			}
		}
	};
}