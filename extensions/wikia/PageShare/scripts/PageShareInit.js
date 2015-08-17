require(['wikia.pageShare', 'jquery'], function (pageShare, $) {
	'use strict';

	// bind events to links
	$(function () {
		pageShare.loadShareIcons();
	});
});
