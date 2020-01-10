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
		playerImpressionsInSession = featuredVideoCookies.getPlayerImpressionsInSession();

	function hasSeenTheVideoInCurrentSession() {
		return videoSeenInSession && currentSession && videoSeenInSession === currentSession;
	}

	function hasMaxedOutPlayerImpressionsInSession(allowedPlayerImpressions) {
		return hasSeenTheVideoInCurrentSession() && playerImpressionsInSession >= allowedPlayerImpressions;
	}

	function setVideoSeenInSession() {
		var newPlayerImpressionsInSession = hasSeenTheVideoInCurrentSession() ? playerImpressionsInSession + 1 : 1;

		featuredVideoCookies.setPlayerImpressionsInSession(newPlayerImpressionsInSession);

		if (hasSeenTheVideoInCurrentSession()) {
			return;
		}

		cookies.set(videoSeenInSessionCookieName, currentSession);
	}

	return {
		setVideoSeenInSession: setVideoSeenInSession,
		hasMaxedOutPlayerImpressionsInSession: hasMaxedOutPlayerImpressionsInSession
	};
});

