define('wikia.articleVideo.featuredVideo.session', [
	'wikia.cookies',
	'wikia.articleVideo.featuredVideo.cookies'
], function (
	cookies,
	featuredVideoCookies
) {
	var videoSeenInSessionCookieName = 'featuredVideoSeenInSession',
		videoSeenInSession = featuredVideoCookies.getVideoSeenInSession(),
		currentSession = cookies.get('wikia_session_id');

	function hasSeenTheVideoInCurrentSession() {
		return videoSeenInSession && currentSession && videoSeenInSession === currentSession;
	}

	function setVideoSeenInSession() {
		if (hasSeenTheVideoInCurrentSession()) {
			return;
		}

		cookies.set(videoSeenInSessionCookieName, currentSession);
	}

	return {
		hasSeenTheVideoInCurrentSession: hasSeenTheVideoInCurrentSession,
		setVideoSeenInSession: setVideoSeenInSession
	};
});

