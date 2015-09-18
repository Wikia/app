define('ext.wikia.adEngine.recovery.message', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.recovery.message';

	function init() {
		log('recoveredAdsMessage initialized', 'debug', logGroup);
	}

	return {
		init: init
	};
});
