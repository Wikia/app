require([
	'jquery',
	'mw',
	'wikia.cookies',
	'wikia.window'
], function (
	$,
	mw,
	cookies,
	window
) {
	'use strict';

	$(function () {
		$('.category-layout-selector__item:not(.is-active)').click(function () {
			var layoutSelected = this.getAttribute('data-category-layout');
			var canonicalUrl = mw.config.get('wgArticlePath').replace('$1', mw.config.get('wgPageName'));
			// We need cachebuster because browser sends `if-none-match` even with location.reload(true) and we get 304
			var location = encodeURI(canonicalUrl) + '?cb=' + (new Date().getTime());

			cookies.set('category-page-layout', layoutSelected, {
				path: '/'
			});

			window.location.replace(location);
		});
	});
});
