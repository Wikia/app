import {context} from '@wikia/ad-engine';
import {navbarManager} from './navbar-updater';
import slots from '../slots';

function getUnstickThreshold() {
	const viewportWidth = Math.max(document.documentElement.clientWidth, window.innerWidth, 0);

	return (viewportWidth / 10 + navbarManager.getHeight()) * 2;
}

export function getConfig() {
	return {
		autoPlayAllowed: true,
		defaultStateAllowed: true,
		fullscreenAllowed: true,
		stickinessAllowed: false,
		bfaaSlotName: context.get('custom.hiviLeaderboard') ? 'hivi_leaderboard' : 'top_leaderboard',
		unstickInstantlyBelowPosition: getUnstickThreshold(),
		topThreshold: navbarManager.getHeight(),

		onInit(adSlot, params) {
			slots.setupSlotVideoAdUnit(adSlot, params);

			const wrapper = document.getElementById('bottomLeaderboardWrapper');

			wrapper.style.width = `${wrapper.offsetWidth}px`;
		}
	};
}
