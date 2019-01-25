/*global define*/
define('ext.wikia.adEngine.wad.wadRecRunner', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.wad.btRecLoader',
	'ext.wikia.adEngine.wad.hmdRecLoader',
	'wikia.log'
], function (adContext, btRecLoader, hmdRecLoader, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.wad.wadRecRunner',
		recEnabled = {
			display: '',
			video: ''
		},
		recs = {
			bt: {
				type: 'display',
				context: 'opts.wadBT',
				loader: btRecLoader
			},
			hmd: {
				type: 'video',
				context: 'opts.wadHMD',
				loader: hmdRecLoader
			}
		};

	function init() {
		log('WAD rec module initialized', 'debug', logGroup);

		Object.keys(recs).forEach(function (rec) {
			var config = recs[rec];

			if (!recEnabled[config.type] && adContext.get(config.context)) {
				recEnabled[config.type] = rec;

				config.loader.init();
			}
		});
	}

	function isEnabled(name) {
		return recEnabled.display === name || recEnabled.video === name;
	}

	return {
		init: init,
		isEnabled: isEnabled
	};
});
