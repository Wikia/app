/* global FB */

/**
 * Render XFBML and Facebook Page Plugin tags emebedded into wikitext
 */
mw.hook('wikipage.content').add(function ($content) {
	'use strict';

	if (facebookTagsOnPage()) {
		$.loadFacebookSDK().done(renderFacebookTags);
	}

	// Checks for XFBML tags or Facebook Page Plugin tags
	function facebookTagsOnPage() {
		var numOfFacebookTags = $content.find('[data-type="xfbml-tag"], .fb-page').length;
		return numOfFacebookTags > 0;
	}

	function renderFacebookTags() {
		FB.XFBML.parse($content[0]);
	}
});
