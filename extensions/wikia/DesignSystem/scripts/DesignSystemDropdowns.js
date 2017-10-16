$(function ($) {
	'use strict';

	var className = 'is-clicked',
		dropdownsSelector = '.wds-dropdown, .wds-dropdown-level-2';

	// On touch devices, the first click opens dropdown, the second one opens the link if there is any
	if (window.Wikia.isTouchScreen()) {
		$('body')
			.on('click', dropdownsSelector, function (event) {
				if (!$(this).hasClass(className)) {
					event.preventDefault();
				}
			})
			.on('mouseenter', dropdownsSelector, function () {
				var $this = $(this);

				// Execute this code after all mouse events are done
				setTimeout(function () {
					$this.addClass(className);
				}, 0);
			})
			.on('mouseleave', dropdownsSelector, function () {
				$(this).removeClass(className);
			});
	}
});
