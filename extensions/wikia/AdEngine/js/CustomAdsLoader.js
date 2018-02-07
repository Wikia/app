/*global require*/
(function() {
	'use strict';

	var availableTemplates = ['bfaa', 'bfab', 'floatingRail', 'floor', 'floorAdhesion', 'interstitial', 'modal',
			'playwire', 'porvata', 'roadblock', 'skin'],
		dependencies = ['wikia.log'];

	function getAdModule(name, allModules) {
		return allModules[availableTemplates.indexOf(name)];
	}

	define(
		'ext.wikia.adEngine.customAdsLoader',
		dependencies.concat(
			availableTemplates.map(function(templateName) {
				return require.optional('ext.wikia.adEngine.template.' + templateName);
			})
		),
		function (log /* template modules */) {
			var logGroup = 'ext.wikia.adEngine.customAdsLoader',
				allModules = Array.prototype.slice.call(arguments).slice(dependencies.length);

			function loadCustomAd(params) {
				log('loadCustomAd: module ' + params.type + ' required', 'debug', logGroup);

				var adModule = getAdModule(params.type, allModules);

				if (adModule){
					log('loadCustomAd: module ' + params.type + ' found', 'debug', logGroup);
					return adModule.show(params);
				} else {
					log('loadCustomAd: module ' + params.type + ' not found', 'error', logGroup);
				}
			}

			return {
				loadCustomAd: loadCustomAd
			};
		}
	);
})();
