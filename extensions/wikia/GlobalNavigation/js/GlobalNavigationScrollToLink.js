require(['wikia.scrollToLink', 'jquery'], function(scrollToLink, $) {
	'use strict';

	$(function initScrollToLink() {
		var additionalSpacing = 16,
			offset = document.getElementById('globalNavigation').offsetHeight + additionalSpacing;

		scrollToLink.handleLinkTo(window.location.hash, offset);

		$('body').on('click', 'a', function scrollToLinkHandler(event) {
			if (scrollToLink.handleLinkTo(this.getAttribute('href'), offset)) {
				event.preventDefault();
			}
		});
	});
});
