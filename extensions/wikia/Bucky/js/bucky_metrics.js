/*
 * This file is used for setting frontend data we want to track in Bucky
 */
require([
	'wikia.geo',
	'wikia.window'
], function (geo, window) {
	'use strict';

	$(function () {
		var wgTransactionContext = window.wgTransactionContext || {};

		wgTransactionContext.country = geo.getCountryCode();
		// send URL without hash since we don't care about it and it breaks queries.
		wgTransactionContext.url = window.location.href.split('#')[0];
		wgTransactionContext.userAgent = window.navigator.userAgent;
		wgTransactionContext.os = window.navigator.platform;
		wgTransactionContext.bodySize = document.getElementsByTagName('body')[0].innerHTML.length;
	});

});
