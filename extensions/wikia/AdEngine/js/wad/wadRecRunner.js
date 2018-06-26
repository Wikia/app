/*global define*/
define('ext.wikia.adEngine.wad.wadRecRunner', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.wad.btRecLoader',
	'ext.wikia.adEngine.wad.ilRecLoader',
	'wikia.log'
], function (adContext, btRecLoader, iltRecLoader, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.wad.wadRecRunner';

	function init() {
		log('WAD recovery module initialized', 'debug', logGroup);

		if (adContext.get('opts.wadBT')) {
			btRecLoader.init();
		}

		if (adContext.get('opts.wadIL')) {
			iltRecLoader.init();
		}
	}

	return {
		init: init
	};
});
