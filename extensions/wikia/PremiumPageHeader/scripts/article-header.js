require(['wikia.window', 'jquery', 'wikia.tracker'], function (window, $, tracker) {
	'use strict';

	$(function () {
		var $articleHeader = $('.pph-article-header'),
			$articleHeaderCategoryLinks = $articleHeader.find('.pph-category-links');

		$articleHeaderCategoryLinks.find('.pph-categories-show-more').on('click', function (e) {
			e.preventDefault();
			$articleHeaderCategoryLinks.toggleClass('show-more');
		});
	});
});
