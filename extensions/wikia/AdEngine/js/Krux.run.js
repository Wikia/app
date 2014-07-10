/*global require*/
/*jshint camelcase:false*/
require([
	'wikia.window',
	'wikia.log',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.krux',
	require.optional('wikia.scriptwriter'),
	require.optional('jquery')
], function (window, log, adLogicPageParams, Krux, scriptWriter, $) {
	'use strict';

	var param, params, value;

	if (window.wgEnableKruxTargeting) {
		// Export page level params, so Krux can read them
		params = adLogicPageParams.getPageLevelParams();
		for (param in params) {
			if (params.hasOwnProperty(param)) {
				value = params[param];
				if (value) {
					window['kruxDartParam_' + param] = value.toString();
				}
			}
		}
		if ('wikiamobile' === window.skin) {
			log('Loading Krux code', 8, 'Krux.run.js');
			Krux.load(window.wgKruxCategoryId);
		} else {
			if (scriptWriter && $) {
				$(window).on('load', function () {
					scriptWriter.callLater(function () {
						log('Loading Krux code', 8, 'Krux.run.js');
						Krux.load(window.wgKruxCategoryId);
					});
				});
			}
		}
	}
});
