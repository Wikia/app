require(
	['wikia.scrollToLink', 'wikia.window', 'venus.variables', 'jquery'],
	function(scrollToLink, win, vars, $) {
	'use strict';

	var offset = 0;

	/**
	 * @desc handler for clicked links
	 * @param {Object} event
	 */
	function scrollToLinkHandler(event) {
		if (scrollToLink.handleScrollTo(this.getAttribute('href'), offset)) {
			// prevent only if we managed to scroll to desired ID
			event.preventDefault();
		}
	}

	/**
	 * @desc Initialize: deal with hash passed as part of URL, bind handler for clicks on link
	 * elements inside BODY
	 */
	function initScrollToLink() {
		// offset is negative - we want scroll BEFORE element's top offset
		offset = -win.document.getElementById('globalNavigation').offsetHeight
			- vars.normalTextFontSize; // also scroll a bit, so element won't be sticked to GlobalNavigation

		scrollToLink.disableBrowserJump();

		// setTimeout is needed here because of Chrome which sometimes scrolls to top on end of page load
		win.setTimeout( function(){
			scrollToLink.handleScrollTo(win.location.hash, offset);
		});

		$('body').on('click', 'a', scrollToLinkHandler);
	}

	// bind to DOMReady
	$(initScrollToLink);
});
