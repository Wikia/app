$(function ($) {
	'use strict';

	$('.wds-dropdown').each(function () {
		window.DS.dropdown.hookDropdown(this);
	});
});
