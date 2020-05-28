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

	function hasMaxedOutPlayerImpressionsInWiki(allowedPlayerImpressions) {
		var playerImpressionsInWiki = featuredVideoCookies.getPlayerImpressionsInWiki() || 0;

		if (!hasSeenTheVideoInCurrentSession()) {
			return false;
		}

		if (allowedPlayerImpressions === 0) {
			return true;
		}

		return playerImpressionsInWiki >= allowedPlayerImpressions;
	}

	function setVideoSeenInSession() {
		var playerImpressionsInWiki = featuredVideoCookies.getPlayerImpressionsInWiki() || 0;
		var videoSeenInSessionCookieName = 'featuredVideoSeenInSession';
		var currentSession = cookies.get('wikia_session_id');

		if (!hasSeenTheVideoInCurrentSession()) {
			cookies.set(videoSeenInSessionCookieName, currentSession);
			featuredVideoCookies.setPlayerImpressionsInWiki(1);
		} else {
			featuredVideoCookies.setPlayerImpressionsInWiki(playerImpressionsInWiki + 1);
		}
	}

	return {
		setVideoSeenInSession: setVideoSeenInSession,
		hasMaxedOutPlayerImpressionsInWiki: hasMaxedOutPlayerImpressionsInWiki
	};
});

