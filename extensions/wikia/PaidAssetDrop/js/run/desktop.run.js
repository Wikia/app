/*global require*/
(function () {
	'use strict';

	var pad = require('ext.wikia.paidAssetDrop.paidAssetDrop'),
		$ = require('jquery'),
		log = require('wikia.log'),
		Querystring = require('wikia.querystring'),
		win = require('wikia.window'),
		action = new Querystring().getVal('action', 'view'),
		articleTarget = '#mw-content-text',
		mainPageTarget = '#mw-content-text .lcs-container',
		pageType,
		target;

	if (win.wgIsMainPage && $(mainPageTarget).length) {
		pageType = 'home';
		target = mainPageTarget;
	} else {
		pageType = 'article';
		target = articleTarget;
	}

	// Everything starts after content and JS
	win.wgAfterContentAndJS.push(function () {
		if (win.wgNamespaceNumber !== 0) {
			log('PAD: Disabled: not a main namespace', 'debug', 'ext.wikia.paidAssetDrop.paidAssetDrop');
			return;
		}

		if (action !== 'view') {
			log('PAD: Disabled: not a view action', 'debug', 'ext.wikia.paidAssetDrop.paidAssetDrop');
			return;
		}

		if (pad.isNowValid(win.wgPaidAssetDropConfig) && win.wgEnableAPI) {
			pad.injectPAD(target, 'desktop', pageType);
		}
	});
})();
