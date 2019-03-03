import { context } from '@wikia/ad-engine';

function getNavbarHeight() {
	const navbar = document.getElementById('globalNavigation');

	return navbar ? navbar.offsetHeight : 0;
}

function getUnstickThreshold() {
	const viewportWidth = Math.max(document.documentElement.clientWidth, window.innerWidth, 0);

	return (viewportWidth / 10 + getNavbarHeight()) * 2;
}

export function getConfig() {
	return {
		autoPlayAllowed: true,
		defaultStateAllowed: true,
		fullscreenAllowed: true,
		stickinessAllowed: false,
		bfaaSlotName: 'TOP_LEADERBOARD',
		unstickInstantlyBelowPosition: getUnstickThreshold(),
		topThreshold: getNavbarHeight(),
		onInit(adSlot, params) {
			const wrapper = document.getElementById('bottomLeaderboardWrapper');

			wrapper.style.width = `${wrapper.offsetWidth}px`;
			context.set(`slots.${adSlot.getSlotName()}.options.isVideoMegaEnabled`, params.isVideoMegaEnabled);
		}
	};
}
