define('wikia.articleVideo.featuredVideo.session', [
	'wikia.cookies',
	'wikia.document',
	'wikia.articleVideo.featuredVideo.cookies'
], function (
	cookies,
	document,
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

		cookies.set(videoSeenInSessionCookieName, currentSession, {
			path: '/'
		});
	}

	return {
		hasSeenTheVideoInCurrentSession: hasSeenTheVideoInCurrentSession,
		setVideoSeenInSession: setVideoSeenInSession
	};
});

