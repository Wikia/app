const navBarStickClass = 'bfaa-pinned';
const navBarElement = document.getElementById('globalNavigation');

function updateNavbar(bfaaConfig) {
	if (isElementInViewport(bfaaConfig)) {
		navBarElement.classList.add(navBarStickClass);
	} else {
		navBarElement.classList.remove(navBarStickClass);
	}
}

function isElementInViewport(bfaaConfig) {
	let position = window.scrollY || window.pageYOffset;

	return position <= document.body.offsetWidth / bfaaConfig.aspectRatio.default;
}

export default updateNavbar;
