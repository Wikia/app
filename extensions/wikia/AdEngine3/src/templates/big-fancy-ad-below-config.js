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
		stickinessAllowed: context.get('options.bfabStickiness'),
		bfaaSlotName: context.get('custom.hiviLeaderboard') ? 'hivi_leaderboard' : 'top_leaderboard',
		unstickInstantlyBelowPosition: getUnstickThreshold(),
		topThreshold: getNavbarHeight(),
		onInit() {
			const wrapper = document.getElementById('bottomLeaderboardWrapper');

			wrapper.style.width = `${wrapper.offsetWidth}px`;
		}
	};
}
