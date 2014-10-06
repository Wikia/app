$(function() {
	'use strict';

	// fix for anchored elements
	var fromTop = $('#globalNavigation').height() + 10; /* 10px of additional padding */

	/**
	 * Check a href for an anchor. If exists, and in document, scroll to it.
	 * If href argument ommited, assumes context (this) is HTML Element,
	 * which will be the case when invoked by jQuery after an event
	 *
	 * based on this solution: http://jsfiddle.net/ianclark001/aShQL/
	 */
	function scroll_if_anchor(href) {
		href = typeof(href) === 'string' ? href : $(this).attr('href');

		// If our Href points to a valid, non-empty anchor, and is on the same page (e.g. #foo)
		// Legacy jQuery and IE7 may have issues: http://stackoverflow.com/q/1593174
		if(href.indexOf("#") === 0) {
			var $target = $(href);

			// Older browser without pushState might flicker here, as they momentarily
			// jump to the wrong position (IE < 10)
			if($target.length) {
				$('html, body').animate({ scrollTop: $target.offset().top - fromTop });
				if(history && "pushState" in history) {
					history.pushState({}, document.title, window.location.pathname + href);
					return false;
				}
			}
		}
	}

	// When our page loads, check to see if it contains and anchor
	scroll_if_anchor(window.location.hash);

	// Intercept all anchor clicks
	$('body').on('click', 'a', scroll_if_anchor);
});
