const navBarStickClass = 'bfaa-pinned';
const navBarElement = document.getElementById('globalNavigation');
const TLBElement = document.getElementById('TOP_LEADERBOARD');

function updateNavbar() {
	if (isElementInViewport(TLBElement)) {
		navBarElement.classList.add(navBarStickClass);
	} else {
		navBarElement.classList.remove(navBarStickClass);
	}
}

function isElementInViewport(element) {
	let position = window.scrollY || window.pageYOffset;
	return position <= element.clientHeight;
}

export default updateNavbar;
