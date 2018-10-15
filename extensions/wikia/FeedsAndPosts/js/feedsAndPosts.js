require(['jquery'], function ($) {
	// Use number of hours passed since Jan. 1, 1970. That way cache is busted at most every hour.
	var version = Math.floor((new Date()).getTime() / (60 * 60 * 1000));
	var fpLibrary = '/feeds-and-posts/public/dist/lib.min.js?' + version;

	$('#WikiaRail').one('afterLoad.rail', function() {
		$.getScript(fpLibrary, function () {
			var wikiName = $('meta[property="og:site_name"]').prop('content');

			// Load FP into a newly inserted element
			$('#wikia-recent-activity').after('<div class="rail-module feed-posts-module"></div>');
			var fpContainer = $('.feed-posts-module').get(0);
			window.fp.default(fpContainer, {
				communityName: wikiName,
				communityId: wgCityId,
				dbName: wgDBname
			});
		});
	});
});
