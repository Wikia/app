require(['wikia.window','LyricFindTracker', 'wikia.log'], function(window, tracker, log) {
	tracker(window.wgArticleId);
	log('tracking page view', log.levels.info, 'LyricFind');
});
