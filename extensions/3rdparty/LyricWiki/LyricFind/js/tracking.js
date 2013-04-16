require(['jquery','LyricFindTracker', 'wikia.log'], function($, tracker, log) {
	var amgId = parseInt($('#lyric').data('amg-id'), 10);

	tracker(amgId);
	log('tracking page view', log.levels.info, 'LyricFind');
});
