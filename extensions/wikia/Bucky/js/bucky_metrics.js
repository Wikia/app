/*
 * This file is used for setting frontend data we want to track in Bucky
 */
require([
	'jquery',
	'wikia.geo',
	'wikia.window',
	'bucky.resourceTiming'
], function ($, geo, window, resourceTiming) {
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

	/**
	 * Report detailed statistics on assets fetched while loading the page
	 *
	 * @see PLATFORM-645
	 *
	 * Bind to onDOMReady, windowLoad and five-seconds-after-windowLoad events
	 * and send ResourceTiming statistics for resources fetched before these events
	 *
	if (!resourceTiming.isSupported()) {
		return;
	}

	$(function () {
		resourceTiming.reportToBucky('DomReady');
	});

	$(window).load(function () {
		resourceTiming.reportToBucky('WindowLoad');

		setTimeout(function () {
			resourceTiming.reportToBucky('AfterWindowLoad');
		}, 5000);
	});
	 **/
});
