require(['jquery'], function ($) {
	var fpLibrary = window.location.protocol + '//' + window.wgDBname + '.wikia.com/feeds-and-posts/public/dist/lib.min.js';

	$('#WikiaRail').one('afterLoad.rail', function() {
		$.getScript(fpLibrary, function () {
			// Load FP into a newly inserted element
			$('#wikia-recent-activity').after('<div class="rail-module feed-posts-module"></div>');
			var fpContainer = $('.feed-posts-module').get(0);
			window.fp.default(fpContainer);
		});
	});
});
