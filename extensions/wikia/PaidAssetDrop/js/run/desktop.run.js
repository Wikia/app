/*global require*/
require([
	'ext.wikia.paidAssetDrop.paidAssetDrop',
	'jquery',
	'wikia.log',
	'wikia.querystring',
	'wikia.window'
], function (
	pad,
	$,
	log,
	Querystring,
	win
) {
	'use strict';

	var action = new Querystring().getVal('action', 'view'),
		articleTarget = '#mw-content-text',
		mainPageTarget = '#mw-content-text .lcs-container',
		target;

	if (win.wgIsMainPage && $(mainPageTarget).length) {
		target = mainPageTarget;
	} else {
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
			pad.injectPAD(target, 'desktop');
		}
	});
});
