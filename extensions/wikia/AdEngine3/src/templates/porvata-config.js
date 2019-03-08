function getNavbarHeight() {
	const navbar = document.getElementById('globalNavigation');

	return navbar ? navbar.offsetHeight : 0;
}

export const getConfig = () => ({
		inViewportOffsetTop: getNavbarHeight(),
		isFloatingEnabled: true,
		onInit: (adSlot, params) => {
			params.viewportHookElement = document.getElementById('INCONTENT_WRAPPER');
		},
	}
);

export default {
	getConfig,
};
