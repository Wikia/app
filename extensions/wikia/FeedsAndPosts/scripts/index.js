require(['jquery', 'wikia.tracker'], function ($, tracker) {
	// Use number of hours passed since Jan. 1, 1970. That way cache is busted at most every hour.
	var version = Math.floor((new Date()).getTime() / (60 * 60 * 1000));
	var fpLibrary = '/feeds-and-posts/public/dist/lib.min.js?' + version;

	var track = tracker.buildTrackingFunction({
		trackingMethod: 'analytics'
	});

	$('#WikiaRail').one('afterLoad.rail', function () {
		$.getScript(fpLibrary, function () {
			var wikiName = $('meta[property="og:site_name"]').prop('content');

			// Load FP into a newly inserted element
			$('#recirculation-rail').append('<div class="rail-module feed-posts-module"></div>');
			var fpContainer = $('.feed-posts-module').get(0);
			window.fandomEmbeddedFeeds.default(fpContainer, {
				communityName: wikiName,
				track: track,
			});
		});
	});
});
