define('ext.wikia.PaidAssetDrop', [
	'jquery',
	'wikia.log'
], function ($, log) {
	'use strict';

	var logGroup = 'ext.wikia.PaidAssetDrop',
		articleContentId = '#mw-content-text';

	log('Paid Asset Drop enabled', 'info', logGroup);

	function isTodayValid() {
		//TODO: change me/finish me!
		return true;
	}

	function injectPad() {
		$(articleContentId).prepend('<h1>PAD test</h1>');
	}

	return {
		isTodayValid: isTodayValid,
		injectPAD: injectPad
	};
});

require(['ext.wikia.PaidAssetDrop'], function(pad) {
	'use strict';

	if (pad.isTodayValid()) {
		pad.injectPAD();
	}
});
