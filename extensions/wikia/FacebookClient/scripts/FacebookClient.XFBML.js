/* global FB */

/**
 * Render FB XML tags emebedded into wikitext
 * This file is loaded via ResourceLoader only when FB XML tags are present on the page
 */
$(function () {
	'use strict';

	// load api on page load and on demand
	mw.hook('wikipage.content').add(function ($content) {
		$.loadFacebookAPI(function () {
			// scan the new content for any fb tags
			FB.XFBML.parse($content[0]);
		});
	});
});
