/* Lazy loading for images inside articles (skips wikiamobile)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */
require(['jquery', 'wikia.ImgLzy', 'wikia.browserDetect', 'wikia.window'], function ($, ImgLzy, browserDetect, w) {
	'use strict';

	// detect WebP support as early as possible
	ImgLzy.checkWebPSupport();

	// expose as a global
	window.ImgLzy = ImgLzy;

	$(function () {
		ImgLzy.init();

		// fix iOS bug - not firing scroll event when after refresh page is opened in the middle of its content
		if (browserDetect.isIPad()) {
			w.addEventListener('pageshow', function () {
				// Safari iOS doesn't trigger scroll event after page refresh.
				// This is a hack to manually lazy-load images after browser scroll the page after refreshing.
				// Should be fixed if we found better solution
				w.setTimeout($.proxy(ImgLzy.checkAndLoad, ImgLzy), 0);
			});
		}
	});
});
