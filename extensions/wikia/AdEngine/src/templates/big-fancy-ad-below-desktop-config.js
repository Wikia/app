import { context } from '@wikia/ad-engine';
import AdUnitBuilder from "../ad-unit-builder";

function getNavbarHeight() {
	const navbar = document.getElementById('globalNavigation');

	if (navbar) {
		return navbar.offsetHeight;
	}

	return 0;
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
		bfaaSlotName: 'TOP_LEADERBOARD',
		unstickInstantlyBelowPosition: getUnstickThreshold(),
		topThreshold: getNavbarHeight(),
		onInit(adSlot, params) {
			const wrapper = document.getElementById('bottomLeaderboardWrapper');

			wrapper.style.width = `${wrapper.offsetWidth}px`;
			context.set(`slots.${adSlot.getSlotName()}.options.isVideoMegaEnabled`, params.isVideoMegaEnabled);
			context.set(`slots.${adSlot.getSlotName()}.vast.adUnitId`, AdUnitBuilder.build(adSlot));
		}
	};
}
