import { NavbarManager } from "@wikia/ad-engine";

let navbarManager = null;

export function getNavbarElement() {
	return document.getElementById('globalNavigation');
}

export function getNavbarManager() {
	if (!navbarManager) {
		navbarManager = new NavbarManager(getNavbarElement());
	}

	return navbarManager;
}
