/* global FB */

/**
 * Render XFBML tags emebedded into wikitext
 */
mw.hook('wikipage.content').add(function ($content) {
	'use strict';

	// TODO This can be uncommented and lines 18 through 20 can be deleted 2 weeks after this is released.
	// We need to wait for parser cache to be cleared so that "data-type='xfbml-tag'" will be added to the
	// tags during parsing.
	//	if ((xfbmlTagsOnPage())) {
	//		$.loadFacebookSDK().done(function () {
	//			renderXFBMLTags();
	//		});
	//	}

	$.loadFacebookSDK().done(function () {
		renderXFBMLTags();
	});

	function xfbmlTagsOnPage() {
		var numOfXFBMLTags = $content.find('[data-type="xfbml-tag"]').length;
		return numOfXFBMLTags > 0;
	}

	function renderXFBMLTags() {
		FB.XFBML.parse($content[0]);
	}
});
