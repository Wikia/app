const leaderboard = document.getElementById('TOP_LEADERBOARD');
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

	if (bfaaConfig && bfaaConfig.aspectRatio) {
		return position <= document.body.offsetWidth / bfaaConfig.aspectRatio.default;
	}

	return position <= leaderboard.offsetHeight;
}

export default updateNavbar;
