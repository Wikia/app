$(function ($) {
	'use strict';

	var className = 'is-clicked';

	// On touch devices, the first click opens dropdown, the second one opens the link if there is any
	if (window.Wikia.isTouchScreen()) {
		$('body')
			.on('touchstart', '.wds-dropdown', function (event) {
				if (!$(this).hasClass(className)) {
					$(this).addClass(className);
					event.preventDefault();
				}
			})
			.on('mouseleave', '.wds-dropdown', function () {
				$(this).removeClass(className);
			});
	}
});
