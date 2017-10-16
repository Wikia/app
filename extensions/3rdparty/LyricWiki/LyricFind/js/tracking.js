Wikia.Tracker.ACTIONS.VIEW_LYRIC = 'view_lyric';

require(['jquery','LyricFindTracker', 'wikia.log'], function($, tracker, log) {
	var amgId = parseInt($('#lyric').data('amg-id'), 10) || 0,
        gracenoteId = parseInt($('#gracenoteid').text(), 10) || 0;

    // does the current page contain lyrics?
    if ($('.lyricbox').length === 0) {
        log('not a lyrics page', log.levels.info, 'LyricFind');
        return;
    }

	// Track the view in GA/internal data warehouse.
	Wikia.Tracker.track({
		action: Wikia.Tracker.ACTIONS.VIEW_LYRIC,
		category: 'lyricView',
		trackingMethod: 'analytics'
	});
	
	// Track the view by calling the pixel which uses our LyricFindController to send the stats to LF.
    tracker(amgId, gracenoteId, window.wgPageName);

    log('tracking page view', log.levels.info, 'LyricFind');
});
