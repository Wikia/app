/* global FB */

/**
 * Render FB XML tags emebedded into wikitext
 * This file is loaded via ResourceLoader only when FB XML tags are present on the page
 */
$(function () {
	'use strict';

	// load api on page load. todo: check if we can remove this after https://github.com/Wikia/app/pull/5237 is merged
	$.loadFacebookAPI();

	// load api on demand
	mw.hook('wikipage.content').add(function ($content) {
		$.when($.loadFacebookAPI()).done(function () {
			// scan the new content for any fb tags
			FB.XFBML.parse($content[0]);
		});
	});
});
