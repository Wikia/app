import slots from '../slots';

function getNavbarHeight() {
	const navbar = document.getElementById('globalNavigation');

	return navbar ? navbar.offsetHeight : 0;
}

export const getConfig = () => ({
		inViewportOffsetTop: getNavbarHeight(),
		isFloatingEnabled: true,
		onInit: (adSlot, params) => {
			params.viewportHookElement = document.getElementById('INCONTENT_WRAPPER');
			slots.setupSlotVideoAdUnit(adSlot, params);
		},
	}
);

export default {
	getConfig,
};
