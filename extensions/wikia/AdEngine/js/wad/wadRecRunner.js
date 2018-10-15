/*global define*/
define('ext.wikia.adEngine.wad.wadRecRunner', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.wad.btRecLoader',
	'ext.wikia.adEngine.wad.ilRecLoader',
	'wikia.log'
], function (adContext, btRecLoader, iltRecLoader, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.wad.wadRecRunner',
		recEnabled = '';

	function init() {
		log('WAD rec module initialized', 'debug', logGroup);

		if (!recEnabled && adContext.get('opts.wadIL')) {
			recEnabled = 'il';

			iltRecLoader.init();
		}

		if (!recEnabled && adContext.get('opts.wadBT')) {
			recEnabled = 'bt';

			btRecLoader.init();
		}
	}

	function isEnabled(name) {
		return name === recEnabled;
	}

	return {
		init: init,
		isEnabled: isEnabled
	};
});
