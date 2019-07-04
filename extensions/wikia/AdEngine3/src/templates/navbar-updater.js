export const navBarStickClass = 'bfaa-pinned';
export const navBarElement = document.getElementById('globalNavigation');

/**
 * Checks and returns page navigation bar height
 *
 * @returns {number}
 */
export function getNavbarHeight() {
	const navbar = document.getElementById('globalNavigation');

	return navbar ? navbar.offsetHeight : 0;
}

export function pinNavbar(bfaaPinned) {
	if (bfaaPinned) {
		navBarElement.classList.add(navBarStickClass);
	} else {
		navBarElement.classList.remove(navBarStickClass);
	}
}
