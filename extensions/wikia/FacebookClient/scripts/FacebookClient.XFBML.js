/* global FB */

/**
 * Render XFBML tags emebedded into wikitext
 */
mw.hook('wikipage.content').add(function ($content) {
	'use strict';

	if ((faceBookTagsOnPage())) {
		$.loadFacebookSDK().done(renderFaceBookTags);
	}

	// Checks for XFBML tags or FaceBook Page Plugin tags
	function faceBookTagsOnPage() {
		var numOfFaceBookTags = $content.find('[data-type="xfbml-tag"], .fb-page').length;
		return numOfFaceBookTags > 0;
	}

	function renderFaceBookTags() {
		FB.XFBML.parse($content[0]);
	}
});
