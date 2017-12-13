import ScrollListener from 'ad-engine/src/listeners/scroll-listener';
import SlotTweaker from 'ad-engine/src/services/slot-tweaker';
import updateNavbar from './navbar-updater';

export function getConfig() {
	return {
		slotsToEnable: [
			'BOTTOM_LEADERBOARD',
			'INCONTENT_BOXAD_1'
		],
		onInit(adSlot) {
			SlotTweaker.onReady(adSlot).then((iframe) => {
				updateNavbar(iframe);
			});
			ScrollListener.addCallback(updateNavbar);
		}
	};
}