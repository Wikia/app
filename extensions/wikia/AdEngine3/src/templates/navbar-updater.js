import {NavbarManager} from "@wikia/ad-engine";

export const navbarElement = document.getElementById('globalNavigation');
export const navbarManager = new NavbarManager(navbarElement);
