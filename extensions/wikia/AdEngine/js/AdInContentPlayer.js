/*global define*/
define('ext.wikia.adEngine.adInContentPlayer', [
	'ext.wikia.adEngine.adContext',
	'jquery',
	'wikia.log',
	'wikia.window'
], function (adContext, $, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adInContentPlayer',
		slotName = 'INCONTENT_PLAYER',
		adHtml = '<div id="' + slotName + '" class="wikia-ad default-height"></div>',
		container;

	function init() {
		log('INCONTENT_PLAYER: init()', 'debug', logGroup);

		container = $('#mw-content-text > h2')[1];
		if (!container) {
			log('INCONTENT_PLAYER not added - no 2nd section', 'debug', logGroup);
			return;
		}

		log(container, 'debug', logGroup);
		$(container).after(adHtml);
		win.adslots2.push([slotName]);
	}

	return {
		init: init
	};
});
