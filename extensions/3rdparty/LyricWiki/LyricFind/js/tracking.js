require(['jquery','LyricFindTracker', 'wikia.log'], function($, tracker, log) {
	var amgId = parseInt($('#lyric').data('amg-id'), 10) || 0,
        gracenoteId = parseInt($('#gracenoteid').text(), 10) || 0;

    // does the current page contain lyrics?
    if (!$('.lyricbox').exists()) {
        log('not a lyrics page', log.levels.info, 'LyricFind');
        return;
    }

    tracker(amgId, gracenoteId, window.wgPageName);
    log('tracking page view', log.levels.info, 'LyricFind');
});
