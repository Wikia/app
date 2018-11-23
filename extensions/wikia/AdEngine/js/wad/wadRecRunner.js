/*global define*/
define('ext.wikia.adEngine.wad.wadRecRunner', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.wad.btRecLoader',
	'ext.wikia.adEngine.wad.hmdRecLoader',
	'ext.wikia.adEngine.wad.ilRecLoader',
	'wikia.log'
], function (adContext, btRecLoader, hmdRecLoader, ilRecLoader, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.wad.wadRecRunner',
		recEnabled = {
			display: '',
			video: ''
		},
		recs = {
			il: {
				type: 'display',
				context: 'opts.wadIL',
				loader: ilRecLoader
			},
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

		// ToDo: check Blockthrough recovery
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
