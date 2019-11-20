(function () {
	var videoSeenInSessionCookieName = 'featuredVideoSeenInSession',
		currentSessionCookieName = 'wikia_session_id';

	function getCookieValue(name) {
		var parts = ('; ' + document.cookie).split('; ' + name + '=');

		if (parts.length === 2) {
			return parts.pop().split(';').shift();
		}

		return null;
	}

	function hasSeenTheVideoInCurrentSession(videoSeenInSession, currentSession) {
		return videoSeenInSession && currentSession && videoSeenInSession === currentSession;
	}

	function getCurrentSession() {
		return getCookieValue(currentSessionCookieName);
	}

	function getVideoSeenInSession() {
		return getCookieValue(currentSessionCookieName);
	}

	function setVideoSeenInSession(value) {
		document.cookie = videoSeenInSessionCookieName + '=' + value + '; path=/';
	}

	var videoSeenInSession = getVideoSeenInSession();
	var currentSession = getCurrentSession();

	if (hasSeenTheVideoInCurrentSession(videoSeenInSession, currentSession)) {
		window.hasSeenFeaturedVideoInCurrentSession = true;
		document.body.classList.add('no-featured-video');
	} else {
		setVideoSeenInSession();
	}
})();
