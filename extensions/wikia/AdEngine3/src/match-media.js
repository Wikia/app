function getMatchMedia() {
	let matchMedia = window.matchMedia;

	matchMedia = matchMedia || (window.styleMedia && window.styleMedia.matchMedium);
	matchMedia = matchMedia || (window.media && window.media.matchMedium);
	return matchMedia;
}

export const matchMedia = getMatchMedia();
