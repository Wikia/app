require(['jquery'], function ($) {
	var fpLibrary = window.location.protocol + '//' + window.wgDBname + '.wikia.com/feeds-and-posts/public/dist/lib.min.js';

	$('#WikiaRail').one('afterLoad.rail', function() {
		$.getScript(fpLibrary, function () {
			// Load FP into a newly inserted element
			var fpContainer = $('#wikia-recent-activity').after('<div class="rail-module feed-module"></div>').get(0);
			window.fp.default(fpContainer);
		});
	});
});
