(function () {
	'use strict';

	var pageShare = require('wikia.pageShare'),
		$ = require('jquery');

	// bind events to links
	$(function () {
		pageShare.loadShareIcons();
	});
})();
