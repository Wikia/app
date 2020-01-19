define('wikia.articleVideo.featuredVideo.session', [
	'wikia.cookies',
	'wikia.articleVideo.featuredVideo.cookies'
], function (
	cookies,
	featuredVideoCookies
) {
	var videoSeenInSessionCookieName = 'featuredVideoSeenInSession',
		videoSeenInSession = featuredVideoCookies.getVideoSeenInSession(),
		currentSession = cookies.get('wikia_session_id'),
		playerImpressionsInSession = featuredVideoCookies.getPlayerImpressionsInSession() || 0;

	function hasSeenTheVideoInCurrentSession() {
		return videoSeenInSession && currentSession && videoSeenInSession === currentSession;
	}

	function hasMaxedOutPlayerImpressionsInSession(allowedPlayerImpressions) {
		if (!hasSeenTheVideoInCurrentSession()) {
			return false;
		}

		if (allowedPlayerImpressions === 0) {
			return true;
		}

		return playerImpressionsInSession >= allowedPlayerImpressions;
	}

	function setVideoSeenInSession() {
		if (!hasSeenTheVideoInCurrentSession()) {
			cookies.set(videoSeenInSessionCookieName, currentSession);
			featuredVideoCookies.setPlayerImpressionsInSession(1);
		} else {
			featuredVideoCookies.setPlayerImpressionsInSession(playerImpressionsInSession + 1);
		}
	}

	return {
		setVideoSeenInSession: setVideoSeenInSession,
		hasMaxedOutPlayerImpressionsInSession: hasMaxedOutPlayerImpressionsInSession
	};
});

