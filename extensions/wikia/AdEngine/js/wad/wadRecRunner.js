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

		var recEnabled = false;

		if (!recEnabled && adContext.get('opts.wadIL')) {
			recEnabled = true;

			iltRecLoader.init();
		}

		if (!recEnabled && adContext.get('opts.wadBT')) {
			recEnabled = true;

			btRecLoader.init();
		}
	}

	return {
		init: init
	};
});
