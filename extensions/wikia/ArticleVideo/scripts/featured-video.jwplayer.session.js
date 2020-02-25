define('wikia.articleVideo.featuredVideo.session', [
	'wikia.cookies',
	'wikia.articleVideo.featuredVideo.cookies'
], function (
	cookies,
	featuredVideoCookies
) {
	'use strict';

	function hasSeenTheVideoInCurrentSession() {
		var videoSeenInSession = featuredVideoCookies.getVideoSeenInSession();
		var currentSession = cookies.get('wikia_session_id');

		return videoSeenInSession && currentSession && videoSeenInSession === currentSession;
	}

	function hasMaxedOutPlayerImpressionsInSession(allowedPlayerImpressions) {
		var playerImpressionsInSession = featuredVideoCookies.getPlayerImpressionsInSession() || 0;

		if (!hasSeenTheVideoInCurrentSession()) {
			return false;
		}

		if (allowedPlayerImpressions === 0) {
			return true;
		}

		return playerImpressionsInSession >= allowedPlayerImpressions;
	}

	function setVideoSeenInSession() {
		var playerImpressionsInSession = featuredVideoCookies.getPlayerImpressionsInSession() || 0;
		var videoSeenInSessionCookieName = 'featuredVideoSeenInSession';
		var currentSession = cookies.get('wikia_session_id');

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

