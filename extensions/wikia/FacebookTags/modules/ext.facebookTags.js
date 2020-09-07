/* global require, FB */

/**
 * Render XFBML and Facebook Page Plugin tags emebedded into wikitext
 */
require(['jquery', 'mw', 'wikia.loader'], function ($, mw, loader) {
	'use strict';

	mw.hook('wikipage.content').add(function ($content) {
		if (facebookTagsOnPage()) {
			loader({
				type: loader.LIBRARY,
				resources: ['facebook']
			}).done(function () {
				var appId = mw.config.get('fbAppId');

				window.FB.init({
					appId: appId,
					cookie: true,
					version: 'v7.0'
				});

				FB.XFBML.parse($content[0]);
			});
		}

		// Checks for XFBML tags or Facebook Social Plugin tags
		function facebookTagsOnPage() {
			// All fb social plugins have a class which starts with 'fb-'
			// eg, fb-like, fb-share-button, etc
			var numOfFacebookTags = $content.find('[data-type="xfbml-tag"], [class^="fb-"]').length;
			return numOfFacebookTags > 0;
		}
	});
});
