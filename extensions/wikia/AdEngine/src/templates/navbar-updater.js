import { resolvedState } from '@wikia/ad-products';

const lockedStateClass = 'theme-locked';
export const navBarStickClass = 'bfaa-pinned';
export const navBarElement = document.getElementById('globalNavigation');

export function pinNavbar(bfaaPinned) {
	if (bfaaPinned) {
		navBarElement.classList.add(navBarStickClass);
	} else {
		navBarElement.classList.remove(navBarStickClass);
	}
}

export function isElementInViewport(adSlot, params) {
	const position = window.scrollY || window.pageYOffset || 0;
	const container = adSlot.getElement();

	if (params.config && params.config.aspectRatio) {
		const { resolved, default: _default } = params.config.aspectRatio;
		const isResolved = resolvedState.isResolvedState(params) || container.classList.contains(lockedStateClass);

		return position <= document.body.offsetWidth / (isResolved ? resolved : _default);
	}

	return position <= container.offsetHeight;
}
