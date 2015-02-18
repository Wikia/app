/* global FB */

/**
 * Render FB XML tags emebedded into wikitext
 */
$(function () {
	'use strict';

	// load api on page load and on demand
	mw.hook('wikipage.content').add(function ($content) {

		if ((xfbmlTagsOnPage())) {
			if (facebookSDKNotLoaded()) {
				// XFBML tags rendered automatically when SDK loads
				$.loadFacebookSDK();
			} else {
				renderXFBMLTags();
			}
		}

		function xfbmlTagsOnPage() {
			var numOfXFBMLTags = $content.find('[data-type="xfbml-tag"]').length;
			return numOfXFBMLTags > 0;
		}

		function facebookSDKNotLoaded() {
			return typeof FB === 'undefined';
		}

		function renderXFBMLTags() {
			FB.XFBML.parse($content[0]);
		}

	});
});
