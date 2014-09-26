/*
 * This file is used for setting frontend data we want to track in Bucky
 */
require([
	'wikia.geo',
	'wikia.window'
], function(geo, window) {
	'use strict';

	var wgTransactionContext = window.wgTransactionContext || {};

	wgTransactionContext.country = geo.getCountryCode();
	wgTransactionContext.url = window.location.href;
	wgTransactionContext.userAgent = window.navigator.userAgent;
	wgTransactionContext.os = window.navigator.platform;
	wgTransactionContext.bodySize = document.getElementsByTagName('body')[0].innerHTML.length;

});
