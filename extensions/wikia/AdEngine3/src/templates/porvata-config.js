import {navbarManager} from './navbar-updater';
import slots from '../slots';

export const getConfig = () => ({
		inViewportOffsetTop: navbarManager.getHeight(),
		isFloatingEnabled: true,
		onInit: (adSlot, params) => {
			slots.setupSlotVideoAdUnit(adSlot, params);
			params.viewportHookElement = document.getElementById('INCONTENT_WRAPPER');
		},
	}
);

export default {
	getConfig,
};
