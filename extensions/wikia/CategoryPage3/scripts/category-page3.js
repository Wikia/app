require([
	'jquery',
	'wikia.cookies',
], function (
	$,
	cookies
) {
	'use strict';

	$(function () {
		$('.category-layout-selector__item:not(.is-active)').click(function () {
			var layoutSelected = this.getAttribute('data-category-layout');

			cookies.set('category-page-layout', layoutSelected, {
				path: '/'
			});
			window.location.reload(true);
		});
	});
});
