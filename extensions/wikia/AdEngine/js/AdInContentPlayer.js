/*global define*/
define('ext.wikia.adEngine.adInContentPlayer', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageDimensions',
	'jquery',
	'wikia.log',
	'wikia.window'
], function (adContext, adLogicPageDimensions, $, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adInContentPlayer',
		context = adContext.getContext(),
		slotName = 'INCONTENT_PLAYER',
		adHtml = '<div id="' + slotName + '" class="wikia-ad default-height"></div>',
		articleContainer,
		header,
		$header;

	function init() {
		log('INCONTENT_PLAYER: init()', 'debug', logGroup);

		articleContainer = $('#mw-content-text');
		header = $(articleContainer).find('h2')[1];
		if (!header) {
			log('INCONTENT_PLAYER not added - no 2nd section', 'debug', logGroup);
			return;
		}
		log(header, 'debug', logGroup);

		$header = $(header);
		if (context.targeting.skin === 'oasis' && $header.width() < articleContainer.width()) {
			log('INCONTENT_PLAYER not added - section is not full width', 'debug', logGroup);
			return;
		}

		$header.before(adHtml);
		win.adslots2.push(slotName);
	}

	return {
		init: init
	};
});
