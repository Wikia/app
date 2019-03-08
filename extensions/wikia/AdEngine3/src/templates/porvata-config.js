import { getNavbarHeight } from './navbar-updater';

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
