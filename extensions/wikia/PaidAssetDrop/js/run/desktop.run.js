/*global require*/
require([
	'ext.wikia.paidAssetDrop.paidAssetDrop',
	'wikia.log',
	'wikia.querystring',
	'wikia.window'
], function (
	pad,
	log,
	Querystring,
	win
) {
	'use strict';

	var action = new Querystring().getVal('action', 'view');

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
			pad.injectPAD('#mw-content-text', 'desktop');
		}
	});
});
