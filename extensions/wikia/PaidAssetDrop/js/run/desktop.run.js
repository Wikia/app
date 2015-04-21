require([
	'ext.wikia.paidAssetDrop.paidAssetDrop',
	'wikia.window'
], function(
	pad,
	win
) {
	'use strict';

	// Everything starts after content and JS
	win.wgAfterContentAndJS.push(function () {
		if (pad.isNowValid() && win.wgEnableAPI) {
			pad.injectPAD();
		}
	});
});
