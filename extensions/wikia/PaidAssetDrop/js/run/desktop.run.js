require([
	'ext.wikia.paidAssetDrop.paidAssetDrop',
	'wikia.log',
	'wikia.window'
], function(
	pad,
	log,
	win
) {
	'use strict';

	// Everything starts after content and JS
	win.wgAfterContentAndJS.push(function () {
		if (win.wgNamespaceNumber !== 0) {
			log('PAD: Not a main namespace', 'debug', 'ext.wikia.paidAssetDrop.paidAssetDrop');
			return;
		}

		if (pad.isNowValid() && win.wgEnableAPI) {
			pad.injectPAD();
		}
	});
});
