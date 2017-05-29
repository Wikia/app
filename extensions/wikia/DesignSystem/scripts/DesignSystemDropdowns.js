$(function ($) {
	'use strict';

	var className = 'is-clicked';

	// On touch devices, the first click opens dropdown, the second one opens the link if there is any
	if (window.Wikia.isTouchScreen()) {
		$(window.document)
			.on('click', '.wds-dropdown, .wds-dropdown-level-2', function (event) {
				if (!$(this).hasClass(className)) {
					$(this).addClass(className);
					event.preventDefault();
				}
			})
			.on('mouseleave', '.wds-dropdown, .wds-dropdown-level-2', function () {
				$(this).removeClass(className);
			});
	}
});
