/* global FB */

/**
 * Render XFBML and Facebook Page Plugin tags emebedded into wikitext
 */
mw.hook('wikipage.content').add(function ($content) {
	'use strict';

	if (facebookTagsOnPage()) {
		$.loadFacebookSDK().done(renderFacebookTags);
	}

	// Checks for XFBML tags or Facebook Social Plugin tags
	function facebookTagsOnPage() {
		// All fb social plugins have a class which starts with 'fb-'
		// eg, fb-like, fb-share-button, etc
		var numOfFacebookTags = $content.find('[data-type="xfbml-tag"], [class^="fb-"]').length;
		return numOfFacebookTags > 0;
	}

	function renderFacebookTags() {
		FB.XFBML.parse($content[0]);
	}
});
