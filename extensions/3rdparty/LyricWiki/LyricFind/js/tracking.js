require(['jquery','LyricFindTracker', 'wikia.log'], function($, tracker, log) {
	var amgId = parseInt($('#lyric').data('amg-id'), 10);

	if (amgId) {
		tracker(amgId);
		log('tracking page view', log.levels.info, 'LyricFind');
	}
	else {
		log('failed to get AMG id', log.levels.error, 'LyricFind');
	}
});
