/*global define*/
define('ext.wikia.adEngine.wad.wadRecRunner', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.wad.btRecLoader',
	'wikia.log'
], function (adContext, btRecLoader, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.wad.wadRecRunner';

	function init() {
		log('WAD rec module initialized', 'debug', logGroup);

		if (adContext.get('opts.wadBT')) {
			btRecLoader.init();
		}
	}

	return {
		init: init
	};
});
